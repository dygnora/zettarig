<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pembayaran_model', 'pembayaran_model');
    }

    /**
     * LIST PEMBAYARAN TRANSFER
     */
    public function index()
    {
        $data['title']      = 'Pembayaran Transfer';
        $data['pembayaran'] = $this->pembayaran_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar');
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/pembayaran/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * DETAIL PEMBAYARAN
     */
    public function detail($id)
    {
        $pembayaran = $this->pembayaran_model->get_by_id($id);

        if (!$pembayaran) {
            show_404();
        }

        $data['title']      = 'Detail Pembayaran Transfer';
        $data['pembayaran'] = $pembayaran;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar');
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/pembayaran/detail', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * VERIFIKASI PEMBAYARAN
     */
    public function verifikasi($id, $status)
    {
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status tidak valid');
        }

        $this->pembayaran_model->verifikasi($id, $status);
        redirect('admin/pembayaran');
    }
}
