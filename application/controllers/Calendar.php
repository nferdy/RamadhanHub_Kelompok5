<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller
{
    public function index()
    {
        $data = array(
            'page_title' => 'Kalender Ramadhan',
            'active_menu' => 'calendar',
            'content' => 'pages/calendar'
        );

        $this->load->view('layouts/main', $data);
    }
}
