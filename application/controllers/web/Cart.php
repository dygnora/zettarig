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
    // TAMBAH KE CART (FIXED: MENYIMPAN SLUG)
    // ==================================================
    public function add($slug)
    {
        // 1. Cek Login
        if (!$this->session->userdata('customer_logged_in')) {
            $this->session->set_userdata('redirect_after_login', current_url());
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login');
            return;
        }

        // 2. Ambil Data Produk
        $produk = $this->Produk_model->get_by_slug($slug);

        if (!$produk || !$produk->status_aktif) {
            show_404();
            return;
        }

        // 3. Cek Stok
        if ($produk->stok <= 0) {
            $this->session->set_flashdata('error', 'Stok produk habis.');
            redirect('produk/'.$slug);
            return;
        }

        // 4. Masukkan ke Keranjang (DENGAN SLUG DI OPTIONS)
        $data = [
            'id'      => $produk->id_produk,
            'qty'     => 1,
            'price'   => $produk->harga_jual,
            'name'    => $produk->nama_produk,
            'options' => [
                'gambar' => $produk->gambar_produk,
                'brand'  => $produk->nama_brand,
                'slug'   => $produk->slug_produk 
            ]
        ];

        $this->cart->insert($data);

        // ===============================
        // SIMPAN KE DATABASE
        // ===============================
        if ($this->session->userdata('customer_logged_in')) {
            $this->Produk_model->save_cart_to_db($this->session->userdata('customer_id'));
        }

        $this->session->set_flashdata('success', 'Hardware ditambahkan ke inventory.');
        redirect('cart');
    }

    // ==================================================
    // BELI LANGSUNG (BUY NOW)
    // ==================================================
    public function buy($slug)
    {
        if (!$this->session->userdata('customer_logged_in')) {
            $this->session->set_userdata('redirect_after_login', 'checkout');
            redirect('auth/login');
            return;
        }

        $produk = $this->Produk_model->get_by_slug($slug);

        if ($produk && $produk->stok > 0) {
            $data = [
                'id'      => $produk->id_produk,
                'qty'     => 1,
                'price'   => $produk->harga_jual,
                'name'    => $produk->nama_produk,
                'options' => [
                    'gambar' => $produk->gambar_produk,
                    'brand'  => $produk->nama_brand,
                    'slug'   => $produk->slug_produk
                ]
            ];
            $this->cart->insert($data);

            // ===============================
            // SIMPAN KE DATABASE
            // ===============================
            if ($this->session->userdata('customer_logged_in')) {
                $this->Produk_model->save_cart_to_db($this->session->userdata('customer_id'));
            }

            redirect('checkout');
        } else {
            redirect('produk/'.$slug);
        }
    }

    // ==================================================
    // UPDATE CART (DENGAN VALIDASI STOK)
    // ==================================================
    public function update()
    {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
        }

        $rowid = $this->input->post('rowid');
        $qty   = (int) $this->input->post('qty');

        // 1. Ambil Data Item di Cart saat ini
        $cart_item = $this->cart->get_item($rowid);

        if ($cart_item && $qty > 0) {
            
            // 2. Ambil Stok Real-time dari Database
            $produk_db = $this->Produk_model->get_by_id($cart_item['id']);

            if ($produk_db) {
                // 3. Cek apakah Quantity melebihi Stok
                if ($qty > $produk_db->stok) {
                    
                    // Kena Limit: Set qty jadi maksimal stok yang ada
                    $qty = $produk_db->stok; 
                    
                    $this->session->set_flashdata(
                        'error', 
                        'Stok tidak mencukupi. Maksimal: ' . $produk_db->stok . ' unit.'
                    );
                } else {
                    $this->session->set_flashdata('success', 'Keranjang diperbarui.');
                }

                // 4. Update Cart
                $this->cart->update([
                    'rowid' => $rowid,
                    'qty'   => $qty
                ]);

                // ===============================
                // SIMPAN KE DATABASE
                // ===============================
                if ($this->session->userdata('customer_logged_in')) {
                    $this->Produk_model->save_cart_to_db($this->session->userdata('customer_id'));
                }
            }
        }

        redirect('cart');
    }

    // ==================================================
    // REMOVE ITEM
    // ==================================================
    public function remove($rowid)
    {
        if (!$this->session->userdata('customer_logged_in')) redirect('auth/login');
        
        $this->cart->remove($rowid);

        // ===============================
        // SIMPAN KE DATABASE (UPDATE HAPUS)
        // ===============================
        if ($this->session->userdata('customer_logged_in')) {
            $this->Produk_model->save_cart_to_db($this->session->userdata('customer_id'));
        }

        redirect('cart');
    }
}