<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticketing extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {

        $data = array();

        $ticket_id = null;

        if (isset($this->uri->segments[2])) $ticket_id = $this->uri->segments[2];

        if (isset($this->uri->segments[3])) {

            $ticket_token = $this->uri->segments[3];
            $ticket_token_id = $this->ticket_model->token($ticket_token);

            if ($ticket_token_id !== $ticket_id) 

                redirect("/");

            $this->session->set_userdata("guest", true);

        }
        

        if ($this->session->userdata('loggedin') || $this->session->userdata('guest')) {

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                if ($ticket_id == "new") {
    
                    $data['tickets'] = null;
    
                } else if ($this->session->userdata('usertype') == "Management") {
                    
                    $data['tickets'] = $this->ticket_model->fetch($ticket_id);
    
                } else if ($ticket_id !== null) {
                    
                    $data['tickets'] = $this->ticket_model->fetch($ticket_id);
    
                } else {
    
                    $data['tickets'] = null;
                }
                
                $this->load->view("ticketing_view.php", $data);
    
            } else {
    
                $post_data = $_POST;
    
                $post_data["id"] = $ticket_id;
    
                $id = $this->ticket_model->upsert($post_data);
    
                redirect("ticketing/$id");
    
            }

        } else {

            redirect('user/login');

        }


    }
}
