<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_admin extends MY_Controller
{
    // Dashboard wajib login
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        $data = $this->data;

        // ================= INFO BOX =================
        $data['total_produk']   = $this->Dashboard_model->count_produk();
        $data['stok_menipis']   = $this->Dashboard_model->count_stok_menipis();
        $data['total_customer'] = $this->Dashboard_model->count_customer();
        $data['total_supplier'] = $this->Dashboard_model->count_supplier();

        // ================= STOK MENIPIS =================
        $data['produk_stok_menipis'] = $this->Dashboard_model->get_produk_stok_menipis();

        // ================= GRAFIK PENDAPATAN =================
        $grafik = $this->Dashboard_model->get_pendapatan_bulanan();
        $bulan_label = [];
        $bulan_pendapatan = [];

        foreach ($grafik as $g) {
            $bulan_label[] = date(
                'M Y',
                mktime(0, 0, 0, $g->bulan_angka, 1, $g->tahun)
            );
            $bulan_pendapatan[] = (int) $g->total;
        }

        $data['bulan_label'] = $bulan_label;
        $data['bulan_pendapatan'] = $bulan_pendapatan;

        // ================= TOTAL UANG =================
        $data['total_revenue'] = $this->Dashboard_model->get_total_revenue();
        $data['total_cost']    = $this->Dashboard_model->get_total_cost();
        $data['total_profit']  = $data['total_revenue'] - $data['total_cost'];

        // ================= LATEST ORDER =================
        $data['latest_orders'] = $this->Dashboard_model->get_latest_orders();

        $data['title'] = 'Dashboard';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer');
    }
}
