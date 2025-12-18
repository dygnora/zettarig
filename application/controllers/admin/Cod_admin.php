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

    // ==================================================
    // LIST COD & DP
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $data['title']   = 'COD & DP';
        $data['cod']     = $this->Cod_model->get_all();
        $data['content'] = 'admin/cod/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL COD
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $cod = $this->Cod_model->get_by_id($id);
        if (!$cod) show_404();

        $data['title']   = 'Detail COD';
        $data['cod']     = $cod;
        $data['content'] = 'admin/cod/detail';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // VERIFIKASI DP
    // ==================================================
    public function verifikasi_dp($id, $status)
    {
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status tidak valid');
        }

        $this->Cod_model->verifikasi_dp($id, $status);
        redirect('admin/cod');
    }

    // ==================================================
    // PELUNASAN COD
    // ==================================================
    public function lunasi($id)
    {
        $this->Cod_model->pelunasan($id);
        redirect('admin/cod');
    }
}
