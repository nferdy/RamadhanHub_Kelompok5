<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prayer extends CI_Controller
{
    public function index()
    {
        $data = array(
            'page_title' => 'Reminder Sholat',
            'active_menu' => 'prayer',
            'content' => 'pages/prayer'
        );

        $this->load->view('layouts/main', $data);
    }
}
