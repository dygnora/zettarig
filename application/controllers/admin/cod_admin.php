<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cod_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cod_model');
    }

    // ===============================
    // LIST COD & DP
    // ===============================
    public function index()
    {
        $data = $this->data;

        $data['title'] = 'COD & DP';
        $data['cod']   = $this->Cod_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/cod/index', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // DETAIL COD
    // ===============================
    public function detail($id)
    {
        $data = $this->data;

        $cod = $this->Cod_model->get_by_id($id);
        if (!$cod) show_404();

        $data['title'] = 'Detail COD';
        $data['cod']   = $cod;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/cod/detail', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // VERIFIKASI DP
    // ===============================
    public function verifikasi_dp($id, $status)
    {
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status tidak valid');
        }

        $this->Cod_model->verifikasi_dp($id, $status);
        redirect('admin/cod');
    }

    // ===============================
    // PELUNASAN
    // ===============================
    public function lunasi($id)
    {
        $this->Cod_model->pelunasan($id);
        redirect('admin/cod');
    }
}
