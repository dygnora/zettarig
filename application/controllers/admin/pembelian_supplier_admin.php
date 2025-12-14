<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_supplier_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Pembelian_supplier_model',
            'Detail_pembelian_supplier_model',
            'Supplier_model',
            'Produk_model'
        ]);
        $this->load->database();
        $this->load->helper(['url']);
    }

    // ===============================
    // INDEX
    // ===============================
    public function index()
    {
        $data = $this->data;

        $data['title']     = 'Pembelian Supplier';
        $data['pembelian'] = $this->Pembelian_supplier_model->get_all_with_supplier();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/pembelian_supplier/index', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $data = $this->data;

        $data['title']    = 'Tambah Pembelian Supplier';
        $data['supplier'] = $this->Supplier_model->get_all_aktif();
        $data['produk']   = $this->Produk_model->get_all_aktif();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/pembelian_supplier/create', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // STORE (TRANSAKSI)
    // ===============================
    public function store()
    {
        $this->db->trans_begin();

        try {
            $id_supplier = $this->input->post('id_supplier');
            $id_produk   = $this->input->post('id_produk');
            $qty         = (int) $this->input->post('jumlah_beli');
            $harga_modal = (int) $this->input->post('harga_modal_satuan');
            $subtotal    = $qty * $harga_modal;

            $id_pembelian = $this->Pembelian_supplier_model->insert([
                'id_supplier' => $id_supplier,
                'total_harga' => $subtotal
            ]);

            $this->Detail_pembelian_supplier_model->insert([
                'id_pembelian'       => $id_pembelian,
                'id_produk'          => $id_produk,
                'jumlah_beli'        => $qty,
                'harga_modal_satuan' => $harga_modal,
                'subtotal'           => $subtotal
            ]);

            $this->Produk_model->update_stok_dan_modal(
                $id_produk,
                $qty,
                $harga_modal
            );

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal menyimpan pembelian');
            }

            $this->db->trans_commit();
            redirect('admin/pembelian_supplier');

        } catch (Exception $e) {
            $this->db->trans_rollback();
            show_error($e->getMessage());
        }
    }

    // ===============================
    // DETAIL
    // ===============================
    public function detail($id)
    {
        $data = $this->data;

        $data['pembelian'] = $this->Pembelian_supplier_model->get_by_id($id);
        $data['detail']    = $this->Detail_pembelian_supplier_model->get_by_pembelian($id);

        if (!$data['pembelian']) show_404();

        $data['title'] = 'Detail Pembelian Supplier';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/pembelian_supplier/detail', $data);
        $this->load->view('admin/layout/footer');
    }
}
