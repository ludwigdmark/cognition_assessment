<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logic extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {

        $this->load->view("logic_view.php");

    }
}
