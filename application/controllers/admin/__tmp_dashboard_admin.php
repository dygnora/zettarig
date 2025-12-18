<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    // ==================================================
    // HALAMAN DASHBOARD ADMIN
    // ==================================================
    public function index()
    {
        $data = $this->data;

        // ==================================================
        // INFO BOX (RINGKASAN DATA)
        // ==================================================
        $data['total_produk']   = $this->Dashboard_model->count_produk();
        $data['stok_menipis']   = $this->Dashboard_model->count_stok_menipis();
        $data['total_customer'] = $this->Dashboard_model->count_customer();
        $data['total_supplier'] = $this->Dashboard_model->count_supplier();

        // ==================================================
        // DAFTAR PRODUK STOK MENIPIS
        // ==================================================
        $data['produk_stok_menipis'] = $this->Dashboard_model->get_produk_stok_menipis();

        // ==================================================
        // GRAFIK PENDAPATAN BULANAN
        // ==================================================
        $grafik = $this->Dashboard_model->get_pendapatan_bulanan();

        $bulan_label      = [];
        $bulan_pendapatan = [];

        foreach ($grafik as $g) {
            $bulan_label[] = date(
                'M Y',
                mktime(0, 0, 0, $g->bulan_angka, 1, $g->tahun)
            );
            $bulan_pendapatan[] = (int) $g->total;
        }

        $data['bulan_label']      = $bulan_label;
        $data['bulan_pendapatan'] = $bulan_pendapatan;

        // ==================================================
        // TOTAL UANG
        // ==================================================
        $data['total_revenue'] = $this->Dashboard_model->get_total_revenue();
        $data['total_cost']    = $this->Dashboard_model->get_total_cost();
        $data['total_profit']  = $data['total_revenue'] - $data['total_cost'];

        // ==================================================
        // PESANAN TERBARU
        // ==================================================
        $data['latest_orders'] = $this->Dashboard_model->get_latest_orders();

        // ==================================================
        // META VIEW
        // ==================================================
        $data['title']   = 'Dashboard';
        $data['content'] = 'admin/dashboard/index';

        // ==================================================
        // RENDER VIA TEMPLATE
        // ==================================================
        $this->load->view('admin/layout/template', $data);
    }
}
