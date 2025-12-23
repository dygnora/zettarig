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
    // HALAMAN CART
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
    // TAMBAH KE CART (NORMAL)
    // ==================================================
    public function add($slug = null)
    {
        if (!$slug) show_404();

        // Cek login
        if (!$this->session->userdata('customer_logged_in')) {
            $this->session->set_userdata('redirect_after_login', current_url());
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login');
            return;
        }

        // Ambil produk
        $produk = $this->Produk_model->get_by_slug($slug);
        if (!$produk || !$produk->status_aktif) show_404();

        // Cek stok
        if ($produk->stok <= 0) {
            $this->session->set_flashdata('error', 'Stok produk habis.');
            redirect('produk/'.$slug);
            return;
        }

        // Insert cart
        $this->cart->insert([
            'id'      => $produk->id_produk,
            'qty'     => 1,
            'price'   => $produk->harga_jual,
            'name'    => $produk->nama_produk,
            'options' => [
                'gambar' => $produk->gambar_produk,
                'brand'  => $produk->nama_brand,
                'slug'   => $produk->slug_produk
            ]
        ]);

        // Simpan ke database
        $this->Produk_model->save_cart_to_db(
            $this->session->userdata('customer_id')
        );

        $this->session->set_flashdata('success', 'Produk ditambahkan ke keranjang.');
        redirect('cart');
    }

    // ==================================================
    // BUY NOW (LANGSUNG KE CHECKOUT)
    // ==================================================
    public function buy($slug = null)
    {
        if (!$slug) show_404();

        // Cek login
        if (!$this->session->userdata('customer_logged_in')) {
            // Kembali ke buy setelah login
            $this->session->set_userdata(
                'redirect_after_login',
                'cart/buy/'.$slug
            );
            redirect('auth/login');
            return;
        }

        // Ambil produk
        $produk = $this->Produk_model->get_by_slug($slug);
        if (!$produk || !$produk->status_aktif) show_404();

        // Cek stok
        if ($produk->stok <= 0) {
            $this->session->set_flashdata('error', 'Stok produk habis.');
            redirect('produk/'.$slug);
            return;
        }

        // 🔥 BUY NOW: kosongkan cart lama
        $this->cart->destroy();

        // Insert item
        $this->cart->insert([
            'id'      => $produk->id_produk,
            'qty'     => 1,
            'price'   => $produk->harga_jual,
            'name'    => $produk->nama_produk,
            'options' => [
                'gambar' => $produk->gambar_produk,
                'brand'  => $produk->nama_brand,
                'slug'   => $produk->slug_produk
            ]
        ]);

        // Simpan ke database
        $this->Produk_model->save_cart_to_db(
            $this->session->userdata('customer_id')
        );

        redirect('checkout');
    }

    // ==================================================
    // UPDATE CART (VALIDASI STOK)
    // ==================================================
    public function update()
    {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            return;
        }

        $rowid = $this->input->post('rowid');
        $qty   = (int) $this->input->post('qty');

        $cart_item = $this->cart->get_item($rowid);
        if (!$cart_item || $qty <= 0) {
            redirect('cart');
            return;
        }

        $produk_db = $this->Produk_model->get_by_id($cart_item['id']);
        if (!$produk_db) redirect('cart');

        if ($qty > $produk_db->stok) {
            $qty = $produk_db->stok;
            $this->session->set_flashdata(
                'error',
                'Stok tidak mencukupi. Maksimal: '.$produk_db->stok
            );
        } else {
            $this->session->set_flashdata('success', 'Keranjang diperbarui.');
        }

        $this->cart->update([
            'rowid' => $rowid,
            'qty'   => $qty
        ]);

        $this->Produk_model->save_cart_to_db(
            $this->session->userdata('customer_id')
        );

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

        $this->Produk_model->save_cart_to_db(
            $this->session->userdata('customer_id')
        );

        redirect('cart');
    }
}
