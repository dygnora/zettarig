<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function index()
    {
        $data = [
            'title'   => 'Zettarig | Computer Parts',
            'content' => 'web/home/index'
        ];

        $this->load->view('web/layout/template', $data);
    }
}
