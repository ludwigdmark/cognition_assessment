<?php defined('BASEPATH') OR exit('No direct script access allowed');

function clean_title($text) {
    return ucwords(str_ireplace("_", " ", $text));
}

function flash_messages() {

    $ci =& get_instance();

    if($ci->session->flashdata('success_msg')) {
        echo "
        <div class='container-fluid'>
            <div class='alert alert-dismissible alert-success'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <h4 class='alert-heading'>Yay!</h4>
                <p class='mb-0'>" . $ci->session->flashdata('success_msg') . "</p>
            </div>
        </div>
        ";
    }

    if($ci->session->flashdata('error_msg')) {
        echo "
        <div class='container-fluid'>
            <div class='alert alert-dismissible alert-danger'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <h4 class='alert-heading'>Oh no!</h4>
                <p class='mb-0'>" . $ci->session->flashdata('error_msg') . "</p>
            </div>
        </div>
        ";
    }

    if($ci->session->flashdata('info_msg')) {
        echo "
        <div class='container-fluid'>
            <div class='alert alert-dismissible alert-info'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <h4 class='alert-heading'>Oh no!</h4>
                <p class='mb-0'>" . $ci->session->flashdata('error_msg') . "</p>
            </div>
        </div>
        ";
    }

    if($ci->session->flashdata('warning_msg')) {
        echo "
        <div class='container-fluid'>
            <div class='alert alert-dismissible alert-warning'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <h4 class='alert-heading'>Oh no!</h4>
                <p class='mb-0'>" . $ci->session->flashdata('error_msg') . "</p>
            </div>
        </div>
        ";
    }

    if($ci->session->flashdata('primary_msg')) {
        echo "
        <div class='container-fluid'>
            <div class='alert alert-dismissible alert-primary'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <h4 class='alert-heading'>Oh no!</h4>
                <p class='mb-0'>" . $ci->session->flashdata('error_msg') . "</p>
            </div>
        </div>
        ";
    }

}

$ci =& get_instance();

$ci->site_data = (object)array();

$ci->reg_data = (object)array();

/* app name */
$ci->site_data->app_title = $ci->config->item('app_title'); 
if (empty($ci->site_data->app_title)) 
    $ci->site_data->app_title = "App";
$ci->site_data->app_title = clean_title($ci->site_data->app_title);

/* page name */
$ci->site_data->page_name = $ci->config->item('landing_page_name'); 

if (isset($ci->uri->segments[1]))
    $ci->site_data->page_name = $ci->uri->segments[1];
if (isset($ci->uri->segments[2]))
    $ci->site_data->page_name .= " " . $ci->uri->segments[2];
$ci->site_data->page_name = clean_title($ci->site_data->page_name);

/* csrf token */
$ci->site_data->csrf = (object)array(
    'name' => $ci->security->get_csrf_token_name(),
    'hash' => $ci->security->get_csrf_hash()
);

$ci->site_data->title = $ci->site_data->app_title . " - " . $ci->site_data->page_name;

$mc = new Memcached();
$mc->addServer("localhost", 11211);

$mc->set("theme", $ci->config->item('default_theme'));