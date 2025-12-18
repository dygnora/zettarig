<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['cart', 'session']);
        $this->load->helper('url');

        // jika cart kosong → balik ke produk
        if ($this->cart->total_items() <= 0) {
            redirect('produk');
        }
    }

    // ==================================================
    // CHECKOUT PAGE
    // ==================================================
    public function index()
    {
        $data['title']   = 'Checkout | Zettarig';
        $data['content'] = 'web/checkout/index';
        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // PROSES CHECKOUT (PLACEHOLDER)
    // ==================================================
    public function process()
    {
        // proteksi login
        if (!$this->session->userdata('customer_login')) {
            redirect('auth/login');
        }

        if ($this->cart->total_items() <= 0) {
            redirect('produk');
        }

        $this->load->model([
            'Penjualan_model',
            'Produk_model'
        ]);

        $customer_id = $this->session->userdata('customer_id');
        $alamat      = $this->input->post('alamat', true);

        $this->db->trans_begin();

        // ===============================
        // SIMPAN PENJUALAN (HEADER)
        // ===============================
        $penjualan = [
            'id_customer'      => $customer_id,
            'tanggal_pesanan'  => date('Y-m-d H:i:s'),
            'total_harga'      => $this->cart->total(),
            'status_pesanan'   => 'baru',
            'alamat_kirim'     => $alamat
        ];

        $this->db->insert('penjualan', $penjualan);
        $id_penjualan = $this->db->insert_id();

        // ===============================
        // SIMPAN DETAIL + KURANGI STOK
        // ===============================
        foreach ($this->cart->contents() as $item) {

            // cek stok ulang (anti race condition)
            $produk = $this->Produk_model->get_by_id($item['id']);
            if (!$produk || $produk->stok < $item['qty']) {
                $this->db->trans_rollback();
                $this->session->set_flashdata(
                    'error',
                    'Stok produk tidak mencukupi: '.$item['name']
                );
                redirect('cart');
                return;
            }

            // detail penjualan
            $detail = [
                'id_penjualan' => $id_penjualan,
                'id_produk'    => $item['id'],
                'qty'          => $item['qty'],
                'harga_jual'   => $item['price'],
                'subtotal'     => $item['subtotal']
            ];

            $this->db->insert('detail_penjualan', $detail);

            // kurangi stok
            $this->Produk_model->kurangi_stok(
                $item['id'],
                $item['qty']
            );
        }

        // ===============================
        // FINAL TRANSAKSI
        // ===============================
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata(
                'error',
                'Terjadi kesalahan saat memproses pesanan.'
            );
            redirect('checkout');
            return;
        }

        $this->db->trans_commit();

        // bersihkan cart
        $this->cart->destroy();

        $this->session->set_flashdata(
            'success',
            'Pesanan berhasil dibuat.'
        );

        redirect('akun/pesanan');
    }

}
