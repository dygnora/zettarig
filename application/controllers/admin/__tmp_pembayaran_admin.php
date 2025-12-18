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

    // ==================================================
    // LIST PEMBAYARAN TRANSFER
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $data['title']      = 'Pembayaran Transfer';
        $data['pembayaran'] = $this->pembayaran_model->get_all();
        $data['content']    = 'admin/pembayaran/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL PEMBAYARAN TRANSFER
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $pembayaran = $this->pembayaran_model->get_by_id($id);
        if (!$pembayaran) show_404();

        $data['title']      = 'Detail Pembayaran Transfer';
        $data['pembayaran'] = $pembayaran;
        $data['content']    = 'admin/pembayaran/detail';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // VERIFIKASI PEMBAYARAN
    // ==================================================
    public function verifikasi($id, $status)
    {
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status tidak valid');
        }

        $this->pembayaran_model->verifikasi($id, $status);
        redirect('admin/pembayaran');
    }
}
