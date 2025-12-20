<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['cart', 'session']);
        $this->load->model('Produk_model');
        $this->load->helper('url');
    }

    // ==================================================
    // HALAMAN CART (WAJIB LOGIN)
    // ==================================================
    public function index()
    {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            return;
        }

        $data['title']   = 'Keranjang | Zettarig';
        $data['content'] = 'web/cart/index';
        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // TAMBAH KE CART (WAJIB LOGIN)
    // ==================================================
    public function add($slug)
    {
        // ===============================
        // PROTEKSI LOGIN
        // ===============================
        if (!$this->session->userdata('customer_logged_in')) {

            // ⛔ WAJIB userdata (bukan flashdata)
            $this->session->set_userdata(
                'redirect_after_login',
                current_url()
            );

            $this->session->set_flashdata(
                'error',
                'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.'
            );

            redirect('auth/login');
            return;
        }

        // ===============================
        // AMBIL PRODUK
        // ===============================
        $produk = $this->Produk_model->get_by_slug($slug);

        if (!$produk || !$produk->status_aktif) {
            show_404();
            return;
        }

        // ===============================
        // CEK STOK
        // ===============================
        if ($produk->stok <= 0) {
            $this->session->set_flashdata('error', 'Stok produk habis.');
            redirect('produk/'.$slug);
            return;
        }

        // ===============================
        // INSERT KE CART
        // ===============================
        $this->cart->insert([
            'id'      => $produk->id_produk,
            'qty'     => 1,
            'price'   => $produk->harga_jual,
            'name'    => $produk->nama_produk,
            'options' => [
                'slug' => $produk->slug_produk
            ]
        ]);

        $this->session->set_flashdata(
            'success',
            'Produk berhasil ditambahkan ke keranjang.'
        );

        redirect('cart');
    }

    // ==================================================
    // UPDATE CART
    // ==================================================
    public function update()
    {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            return;
        }

        foreach ($this->input->post('cart') as $rowid => $item) {
            $this->cart->update([
                'rowid' => $rowid,
                'qty'   => (int) $item['qty']
            ]);
        }

        redirect('cart');
    }

    // ==================================================
    // REMOVE ITEM
    // ==================================================
    public function remove($rowid)
    {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            return;
        }

        $this->cart->remove($rowid);
        redirect('cart');
    }
}
