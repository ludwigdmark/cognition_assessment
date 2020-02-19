<?php defined('BASEPATH') OR exit('No direct script access allowed');


function sendmail() {

    $ci =& get_instance();

    include('/var/www/html/application/libraries/PHPMailer/index.php');

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $ci->config->item('php_mailer_host');
    $mail->SMTPAuth = true;
    $mail->Username = 'apikey';
    $mail->Password = $ci->config->item('php_mailer_password');
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->isHTML(true);
    $mail->setFrom($ci->config->item('php_mailer_from_add'), $ci->config->item('php_mailer_from_name'));

    return $mail;

}

function send_ticket_mail($options) {
    
    $mail = sendmail();
            
    $mail->addAddress(/* $options->email */ "ludwigdmark@gmail.com", $options->fullname);

    $mail->Subject = "A ticket was created for you by Cognition Support";

    $html = file_get_contents("/var/www/html/application/views/partials/email_template.html");
    
    $html = str_ireplace("{{subject}}", "Cognition support ticket #[$options->id] created!", $html);
    $html = str_ireplace("{{greeting}}", "Hello $options->fullname,", $html);
    $html = str_ireplace("{{text_1}}", "A new support ticket was created for you by the Cognition support team. <br> Click the link below to view this ticket.", $html);
    $html = str_ireplace("{{text_2}}", "Your ticket ID is $options->id.", $html);
    $html = str_ireplace("{{signature}}", "Regards, <br> Cognition Support", $html);
    $html = str_ireplace("{{link_text}}", "View Your Ticket", $html);
    $html = str_ireplace("{{link_url}}", "https://cognition.daleludwig.co.za/ticketing/$options->id/$options->ticket_token", $html);

    $mail->Body = $html;   

    $mail->send();

}


function send_ticket_mail_update($options) {
    
    $mail = sendmail();
            
    $mail->addAddress(/* $options->email */ "ludwigdmark@gmail.com", $options->fullname);

    $mail->Subject = "A ticket was updated for you by Cognition Support";

    $html = file_get_contents("/var/www/html/application/views/partials/email_template.html");
    
    $html = str_ireplace("{{subject}}", "Cognition support ticket #[$options->id] created!", $html);
    $html = str_ireplace("{{greeting}}", "Hello $options->fullname,", $html);
    $html = str_ireplace("{{text_1}}", "A support ticket was updated for you by the Cognition support team. <br> Click the link below to view this ticket.", $html);
    $html = str_ireplace("{{text_2}}", "Your ticket ID is $options->id.", $html);
    $html = str_ireplace("{{signature}}", "Regards, <br> Cognition Support", $html);
    $html = str_ireplace("{{link_text}}", "View Your Ticket", $html);
    $html = str_ireplace("{{link_url}}", "https://cognition.daleludwig.co.za/ticketing/$options->id/$options->ticket_token", $html);

    $mail->Body = $html;   

    $mail->send();

}