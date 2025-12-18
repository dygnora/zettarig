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

    // ==================================================
    // LIST PEMBELIAN SUPPLIER
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $data['title']     = 'Pembelian Supplier';
        $data['pembelian'] = $this->Pembelian_supplier_model->get_all_with_supplier();
        $data['content']   = 'admin/pembelian_supplier/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM TAMBAH PEMBELIAN SUPPLIER
    // ==================================================
    public function create()
    {
        $data = $this->data;

        $data['title']    = 'Tambah Pembelian Supplier';
        $data['supplier'] = $this->Supplier_model->get_all_aktif();
        $data['produk']   = $this->Produk_model->get_all_aktif();
        $data['content']  = 'admin/pembelian_supplier/create';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // SIMPAN TRANSAKSI PEMBELIAN SUPPLIER
    // ==================================================
    public function store()
    {
        $this->db->trans_begin();

        try {
            $id_supplier = $this->input->post('id_supplier');
            $id_produk   = $this->input->post('id_produk');
            $qty         = (int) $this->input->post('jumlah_beli');
            $harga_modal = (int) $this->input->post('harga_modal_satuan');
            $subtotal    = $qty * $harga_modal;

            // ==================================================
            // INSERT PEMBELIAN
            // ==================================================
            $id_pembelian = $this->Pembelian_supplier_model->insert([
                'id_supplier' => $id_supplier,
                'total_harga' => $subtotal
            ]);

            // ==================================================
            // INSERT DETAIL PEMBELIAN
            // ==================================================
            $this->Detail_pembelian_supplier_model->insert([
                'id_pembelian'       => $id_pembelian,
                'id_produk'          => $id_produk,
                'jumlah_beli'        => $qty,
                'harga_modal_satuan' => $harga_modal,
                'subtotal'           => $subtotal
            ]);

            // ==================================================
            // UPDATE STOK & HARGA MODAL PRODUK
            // ==================================================
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

    // ==================================================
    // DETAIL PEMBELIAN SUPPLIER
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $pembelian = $this->Pembelian_supplier_model->get_by_id($id);
        if (!$pembelian) show_404();

        $data['title']     = 'Detail Pembelian Supplier';
        $data['pembelian'] = $pembelian;
        $data['detail']    = $this->Detail_pembelian_supplier_model->get_by_pembelian($id);
        $data['content']   = 'admin/pembelian_supplier/detail';

        $this->load->view('admin/layout/template', $data);
    }
}
