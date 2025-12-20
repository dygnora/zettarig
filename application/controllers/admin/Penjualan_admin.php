<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
        $this->load->library(['pagination', 'user_agent']);
    }

    // ==================================================
    // LIST DATA PENJUALAN
    // ==================================================
    public function index()
    {
        $data = $this->data;
        $offset = max((int) $this->input->get('page'), 0);
        $limit  = 10;

        $total_rows = $this->Penjualan_model->count_all();

        // Config Pagination
        $config['base_url']             = base_url('admin/penjualan');
        $config['total_rows']           = $total_rows;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = true;

        // Styling Pagination AdminLTE
        $config['full_tag_open']  = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']  = '</a></li>';
        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['title']      = 'Data Penjualan';
        $data['penjualan']  = $this->Penjualan_model->get_paginated($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset']     = $offset;
        $data['content']    = 'admin/penjualan/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL DATA PENJUALAN
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        $data['title']     = 'Detail Penjualan';
        $data['penjualan'] = $penjualan;
        $data['detail']    = $this->Penjualan_model->get_detail($id);
        $data['timeline']  = $this->Penjualan_model->get_timeline($id);
        $data['content']   = 'admin/penjualan/detail';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // AKSI: PROSES PESANAN
    // ==================================================
    public function proses($id)
    {
        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        $this->Penjualan_model->update_status($id, 'diproses');
        $this->Penjualan_model->add_timeline($id, 'Pesanan Diproses', 'Pesanan sedang diproses admin.');

        $this->session->set_flashdata('success', 'Status diubah menjadi DIPROSES.');
        redirect('admin/penjualan/detail/' . $id);
    }

    // ==================================================
    // AKSI: KIRIM PESANAN
    // ==================================================
    public function kirim($id)
    {
        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        $this->Penjualan_model->update_status($id, 'dikirim');
        $this->Penjualan_model->add_timeline($id, 'Pesanan Dikirim', 'Pesanan dalam pengiriman.');

        $this->session->set_flashdata('success', 'Status diubah menjadi DIKIRIM.');
        redirect('admin/penjualan/detail/' . $id);
    }

    // ==================================================
    // AKSI: SELESAIKAN PESANAN
    // ==================================================
    public function selesai($id)
    {
        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        $this->Penjualan_model->update_status($id, 'selesai');
        $this->Penjualan_model->add_timeline($id, 'Pesanan Selesai', 'Transaksi selesai.');

        $this->session->set_flashdata('success', 'Pesanan SELESAI.');
        redirect('admin/penjualan/detail/' . $id);
    }

    // ==================================================
    // AKSI: BATALKAN PESANAN
    // ==================================================
    public function batal($id)
    {
        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        if ($penjualan->status_pesanan == 'selesai') {
            $this->session->set_flashdata('error', 'Pesanan selesai tidak bisa dibatalkan.');
            redirect('admin/penjualan/detail/' . $id);
            return;
        }

        $this->Penjualan_model->update_status($id, 'dibatalkan');
        $this->Penjualan_model->add_timeline($id, 'Pesanan Dibatalkan', 'Dibatalkan oleh Admin.');

        $this->session->set_flashdata('success', 'Pesanan DIBATALKAN.');
        redirect('admin/penjualan/detail/' . $id);
    }
}