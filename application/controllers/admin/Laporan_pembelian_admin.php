<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pembelian_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_pembelian_model');
    }

    // ==================================================
    // INDEX LAPORAN PEMBELIAN SUPPLIER
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        $data['title'] = 'Laporan Pembelian Supplier';
        $data['start'] = $start;
        $data['end']   = $end;

        $data['laporan'] = $this->Laporan_pembelian_model
            ->laporan_pembelian_supplier($start, $end);

        $data['content'] = 'admin/laporan_pembelian/index';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL LAPORAN PEMBELIAN PER SUPPLIER
    // ==================================================
    public function supplier($id_supplier)
    {
        $data = $this->data;

        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        $supplier = $this->db
            ->get_where('supplier', ['id_supplier' => $id_supplier])
            ->row();

        if (!$supplier) {
            show_404();
        }

        $data['title']    = 'Detail Laporan Pembelian Supplier';
        $data['supplier'] = $supplier;
        $data['start']    = $start;
        $data['end']      = $end;

        $data['detail'] = $this->Laporan_pembelian_model
            ->detail_pembelian_supplier($id_supplier, $start, $end);

        $data['content'] = 'admin/laporan_pembelian/detail';
        $this->load->view('admin/layout/template', $data);
    }
}
