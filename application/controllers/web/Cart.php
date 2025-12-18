<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->library('cart');
        $this->load->helper('url');
    }

    // ==================================================
    // TAMBAH PRODUK KE CART (PAKAI SLUG)
    // URL: /cart/add/{slug}
    // ==================================================
    public function add($slug = null)
    {
        if (!$slug) {
            show_404();
        }

        // ambil produk aktif
        $produk = $this->Produk_model->get_active_by_slug($slug);
        if (!$produk) {
            show_404();
        }

        // cek stok
        if ($produk->stok <= 0) {
            $this->session->set_flashdata('error', 'Stok produk habis.');
            redirect('produk/'.$slug);
            return;
        }

        // data cart
        $data = [
            'id'      => $produk->id_produk,
            'qty'     => 1,
            'price'   => $produk->harga_jual,
            'name'    => $produk->nama_produk,
            'options' => [
                'slug'   => $produk->slug_produk,
                'brand'  => $produk->nama_brand,
                'gambar' => $produk->gambar_produk
            ]
        ];

        $this->cart->insert($data);

        $this->session->set_flashdata('success', 'Produk berhasil ditambahkan ke keranjang.');
        redirect('produk/'.$slug);
    }

    // ==================================================
    // LIHAT CART (placeholder)
    // URL: /cart
    // ==================================================
    public function index()
    {
        $data['title']   = 'Keranjang | Zettarig';
        $data['content'] = 'web/cart/index';
        $this->load->view('web/layout/template', $data);
    }

    // UPDATE QTY
    public function update()
    {
        $rowid = $this->input->post('rowid');
        $qty   = (int) $this->input->post('qty');

        if ($rowid && $qty > 0) {
            $this->cart->update([
                'rowid' => $rowid,
                'qty'   => $qty
            ]);
            $this->session->set_flashdata('success', 'Jumlah produk diperbarui.');
        }

        redirect('cart');
    }

    // REMOVE ITEM
    public function remove($rowid)
    {
        if ($rowid) {
            $this->cart->remove($rowid);
            $this->session->set_flashdata('success', 'Produk dihapus dari keranjang.');
        }
        redirect('cart');
    }

}

