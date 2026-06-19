<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Achievements extends CI_Controller
{
    public function index()
    {
        $data = array(
            'page_title' => 'Achievement Ramadhan',
            'active_menu' => 'achievement',
            'content' => 'pages/achievements'
        );

        $this->load->view('layouts/main', $data);
    }
}
