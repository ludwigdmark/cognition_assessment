<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_model extends CI_model
{

    public function upsert($ticket)
    {        

        if (gettype($ticket) !== "object") $ticket = (object)$ticket;

        if (isset($ticket->id)) {

            $sql = "UPDATE `tickets` SET 
            `ticket_type` = '$ticket->type', `ticket_status` = '$ticket->status', 
            `logged_location` = '$ticket->location', `ticket_details` = '{\"text\":\"$ticket->body\"}'
            WHERE `id` = '$ticket->id';";
            
            $this->db->query($sql);

            $sql = "SELECT `tickets`.`ticket_token`, `tickets`.`id`, `users`.`fullname`, `users`.`email` FROM `tickets` 
            JOIN `users` ON `users`.`email` = `tickets`.`created_for` WHERE `tickets`.`id` = '$ticket->id';";

            $query = $this->db->query($sql);

            send_ticket_mail_update($query->row());

            $updated_id = $ticket->id;

        } else {


            $token = bin2hex(openssl_random_pseudo_bytes(64));

            $sql = "INSERT INTO `cognition`.`tickets`(`ticket_type`, `ticket_status`, `logged_by`, `logged_location`, `created_for`, `ticket_details`, `ticket_token`) 
            VALUES ('$ticket->type', 'Opened', '".$this->session->userdata('email')."', '$ticket->location', '$ticket->email', '{\"text\":\" $ticket->body \"}', '" . $token . "');";
        
            $this->db->query($sql);

            $token = bin2hex(openssl_random_pseudo_bytes(64));
            
            $ticket->firstname = explode(" ", $ticket->fullname)[0];
            $ticket->lastname = explode(" ", $ticket->fullname)[0];

            $sql = "INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `person_data`, `user_token`) 
            SELECT 'Guest', '$ticket->email','$ticket->firstname','$ticket->lastname','$ticket->cell','{}', '$token' WHERE NOT EXISTS (
                SELECT `id` FROM `cognition`.`users` WHERE `email` = '$ticket->email'
            );";
                
            $query = $this->db->query($sql);

            $sql = "SELECT MAX(`id`) AS 'id' FROM `tickets` WHERE `created_for` = '$ticket->email';";
            
            $query = $this->db->query($sql);

            $updated_id = $query->row(0)->id;

            $sql = "SELECT `tickets`.`ticket_token`, `tickets`.`id`, `users`.`fullname`, `users`.`email` FROM `tickets` 
            JOIN `users` ON `users`.`email` = `tickets`.`created_for` WHERE `tickets`.`id` = '$updated_id';";
            $query = $this->db->query($sql);

            send_ticket_mail($query->row());

        }

        return $updated_id;

    }

    public function fetch($id = null)
    {        

        if ($id == null) {
            
            $sql = "SELECT `tickets`.`id`, `users`.`firstname`, `users`.`lastname`, `tickets`.`created_at`, `tickets`.`ticket_status`, `tickets`.`logged_by`
            FROM `tickets` JOIN `users` ON `users`.`email` = `tickets`.`created_for`";
            
            $query = $this->db->query($sql);

            return $query->result_array();

        } else {
            
            $sql = "SELECT `tickets`.`id`, `users`.`fullname`, `users`.`cellno`, `tickets`.`created_at`, `tickets`.`ticket_status`, `tickets`.`ticket_details`,
            `tickets`.`logged_location`, `tickets`.`ticket_type`, `tickets`.`logged_by`, `tickets`.`created_for`
            FROM `tickets` JOIN `users` ON `users`.`email` = `tickets`.`created_for`
            WHERE `tickets`.`id` = '$id';";

            $query = $this->db->query($sql);

            $ticket = $query->row();
            $ticket->ticket_details = json_decode($ticket->ticket_details);

            return $query->row();

        }

    }

    
    public function token($token)
    {        

        $sql = "SELECT `id` FROM `tickets` WHERE `ticket_token` = '$token';";
        
        $query = $this->db->query($sql);

        $ticket_id = $query->row(0)->id;

        return $ticket_id;

    }
    
}
