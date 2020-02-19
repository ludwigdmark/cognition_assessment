<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        if (!$this->session->has_userdata('loggedin')) 
            $this->session->set_userdata('loggedin', false);

    }

    public function index()
    {
        if ($this->session->userdata('loggedin')) {

            redirect('/');

        } else {

            redirect('user/login');

        }

    }

    public function login()
    {

        if ($this->session->userdata('loggedin'))
            
            redirect('/');

        else if ($_SERVER['REQUEST_METHOD'] === 'GET')

            $this->load->view("login_view.php");
    
        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $result = $this->user_model->login($_POST);

            if ($result->outcome == 1) {

                $this->session->set_flashdata('success_msg', $result->message);

                if ($this->session->userdata('usertype') == "Support") {
            
                    redirect('/ticketing/new');

                } else {
            
                    redirect('/ticketing');

                }
                
            } else {
                
                $this->session->set_flashdata('error_msg', $result->message);

                $this->load->view("login_view.php");

            }

        }

    }

    public function logout()
    {

        $this->session->set_userdata('loggedin', false);

        $this->session->set_flashdata('success_msg', 'Logout successful. Hope to see you again soon.');
            
        redirect('user/login');

    }

    public function admin()
    {
            
        if (!$this->session->userdata('loggedin')) {
            
            $this->session->set_flashdata('error_msg', 'You are not authorised to access this page.');

            redirect('user/login');

        }

        if ($this->session->userdata('authgroup') == 'Admin') {

            $this->load->view("user_admin_view.php");

        } else {

            $this->session->set_flashdata('error_msg', 'You are not authorised to access this page.');
            
            redirect('user/login');

        }

    }

//     public function register_user()
//     {

//         $user = array(
//             'user_email' => $this->input->post('user_email'),
//             'user_password' => md5($this->input->post('user_password'))
//         );
//         print_r($user);

//         $email_check = $this->user_model->email_check($user['user_email']);

//         if ($email_check) {
//             $this->user_model->register_user($user);
//             $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
//             redirect('user/login_view');
//         } else {

//             $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
//             redirect('user');
//         }
//     }

//     public function login_view()
//     {
//         $csrf = array(
//             'name' => $this->security->get_csrf_token_name(),
//             'hash' => $this->security->get_csrf_hash()
//     );
//         $this->load->view("login_view.php", array("csrf"=>$csrf));
//     }

//     function login_user()
//     {
//         $user_login = array(

//             'user_email' => $this->input->post('user_email'),
//             'user_password' => md5($this->input->post('user_password'))

//         );

//         $data['users'] = $this->user_model->login_user($user_login['user_email'],$user_login['user_password']);
//          if($data['users'])
//         {

//         $this->session->set_userdata('user_id', $data['users'][0]['user_id']);
//         $this->session->set_userdata('user_email', $data['users'][0]['user_email']);
        
//         $this->load->view('user_profile.php', $data);

//          } else {
//           $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
//           $csrf = array(
//               'name' => $this->security->get_csrf_token_name(),
//               'hash' => $this->security->get_csrf_hash()
//       );
//           $this->load->view("login_view.php", array("csrf"=>$csrf));

//         }


//     }

//     function user_profile()
//     {

//         $this->load->view('user_profile.php');
//     }
//     public function user_logout()
//     {

//         $this->session->sess_destroy();
//         redirect('user/login_view', 'refresh');
//     }
}
