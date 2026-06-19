<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fasting extends CI_Controller
{
    public function index()
    {
        $data = array(
            'page_title' => 'Tracker Puasa',
            'active_menu' => 'fasting',
            'content' => 'pages/fasting'
        );

        $this->load->view('layouts/main', $data);
    }
}
