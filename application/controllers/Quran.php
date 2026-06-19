<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quran extends CI_Controller
{
    public function index()
    {
        $data = array(
            'page_title' => 'Al-Quran Progress',
            'active_menu' => 'quran',
            'content' => 'pages/quran'
        );

        $this->load->view('layouts/main', $data);
    }
}
