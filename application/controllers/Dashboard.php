<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index()
    {
        $data = array(
            'page_title' => 'Dashboard Ramadhan',
            'active_menu' => 'dashboard',
            'content' => 'pages/dashboard'
        );

        $this->load->view('layouts/main', $data);
    }
}
