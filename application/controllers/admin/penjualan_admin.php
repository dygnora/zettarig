<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
    }

    public function index()
    {
        $data = $this->data;

        $data['title']     = 'Data Penjualan';
        $data['penjualan'] = $this->Penjualan_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/penjualan/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function detail($id)
    {
        $data = $this->data;

        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        $data['title']     = 'Detail Penjualan';
        $data['penjualan'] = $penjualan;
        $data['detail']    = $this->Penjualan_model->get_detail($id);
        $data['timeline']  = $this->Penjualan_model->get_timeline($id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/penjualan/detail', $data);
        $this->load->view('admin/layout/footer');
    }
}
