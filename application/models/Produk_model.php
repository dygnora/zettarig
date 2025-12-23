<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    protected $table = 'produk';

    // ==================================================
    // ================= ADMIN SIDE =====================
    // ==================================================

    public function count_all($keyword = null)
    {
        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');

        if ($keyword) {
            $this->db->group_start()
                ->like('p.nama_produk', $keyword)
                ->or_like('k.nama_kategori', $keyword)
                ->or_like('b.nama_brand', $keyword)
                ->group_end();
        }
        return $this->db->count_all_results();
    }

    public function get_paginated($limit, $offset, $keyword = null)
    {
        $this->db->select('p.*, k.nama_kategori, b.nama_brand');
        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');

        if ($keyword) {
            $this->db->group_start()
                ->like('p.nama_produk', $keyword)
                ->or_like('k.nama_kategori', $keyword)
                ->or_like('b.nama_brand', $keyword)
                ->group_end();
        }

        return $this->db->order_by('p.id_produk', 'DESC')
            ->limit($limit, $offset)
            ->get()->result();
    }

    public function get_by_id($id)
    {
        // Digunakan juga untuk validasi stok di Cart
        return $this->db->where('id_produk', $id)->get($this->table)->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_produk', $id)->update($this->table, $data);
    }

    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    public function update_stok_dan_modal($id_produk, $qty, $harga_modal)
    {
        $this->db->set('stok', 'stok + ' . (int)$qty, false);
        $this->db->set('harga_modal', $harga_modal);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update($this->table);
    }

    public function kurangi_stok($id_produk, $qty)
    {
        $this->db->set('stok', 'stok - ' . (int)$qty, false);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update($this->table);
    }

    public function get_all_aktif()
    {
        return $this->db->where('status_aktif', 1)
            ->order_by('nama_produk', 'ASC')
            ->get($this->table)->result();
    }

    // ==================================================
    // ================== WEB SIDE ======================
    // ==================================================

    // [BARU] Ini method yang sebelumnya hilang dan menyebabkan error di Cart
    public function get_by_slug($slug)
    {
        $this->db->select('produk.*, brand.nama_brand');
        $this->db->from('produk');
        $this->db->join('brand', 'brand.id_brand = produk.id_brand', 'left');
        $this->db->where('produk.slug_produk', $slug);
        return $this->db->get()->row();
    }

    // Logika Filter Terpusat (Private)
    private function _apply_web_filters($filters)
    {
        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');
        $this->db->where('p.status_aktif', 1);

        // Filter Keyword
        if (!empty($filters['keyword'])) {
            $this->db->group_start()
                ->like('p.nama_produk', $filters['keyword'])
                ->or_like('b.nama_brand', $filters['keyword'])
                ->or_like('k.nama_kategori', $filters['keyword'])
                ->group_end();
        }

        // Filter Kategori
        if (!empty($filters['kategori'])) {
            $this->db->where('p.id_kategori', $filters['kategori']);
        }

        // Filter Harga Min
        if (!empty($filters['min_price'])) {
            $this->db->where('p.harga_jual >=', $filters['min_price']);
        }

        // Filter Harga Max
        if (!empty($filters['max_price'])) {
            $this->db->where('p.harga_jual <=', $filters['max_price']);
        }
    }

    // 1. Hitung Total Data (Dengan Filter)
    public function count_filtered($filters = [])
    {
        $this->_apply_web_filters($filters);
        return $this->db->count_all_results();
    }

    // 2. Ambil Data (Dengan Filter & Pagination)
    public function get_filtered($limit, $offset, $filters = [])
    {
        $this->db->select('p.*, k.nama_kategori, b.nama_brand');
        $this->_apply_web_filters($filters);
        
        return $this->db->order_by('p.id_produk', 'DESC')
            ->limit($limit, $offset)
            ->get()->result();
    }

    // 3. Detail Produk by Slug (Untuk Halaman Detail)
    public function get_active_by_slug($slug)
    {
        return $this->db
            ->select('p.*, k.nama_kategori, b.nama_brand')
            ->from('produk p')
            ->join('kategori_produk k', 'k.id_kategori = p.id_kategori')
            ->join('brand b', 'b.id_brand = p.id_brand')
            ->where('p.slug_produk', $slug)
            ->where('p.status_aktif', 1)
            ->get()->row();
    }

    // ==================================================
    // FITUR KERANJANG DATABASE (PERSISTENT CART)
    // ==================================================

    // 1. Simpan isi Cart Session saat ini ke Database
    public function save_cart_to_db($id_customer)
    {
        // Hapus dulu keranjang lama milik user ini di DB biar gak duplikat
        $this->db->where('id_customer', $id_customer)->delete('keranjang');

        $cart_content = $this->cart->contents();
        
        if (!empty($cart_content)) {
            $data_batch = [];
            foreach ($cart_content as $item) {
                $data_batch[] = [
                    'id_customer' => $id_customer,
                    'id_produk'   => $item['id'],
                    'qty'         => $item['qty'],
                    'price'       => $item['price'],
                    'name'        => $item['name'],
                    'options'     => json_encode($item['options']) // Array options diubah jadi JSON string
                ];
            }
            $this->db->insert_batch('keranjang', $data_batch);
        }
    }

    // 2. Ambil data dari Database dan masukkan ke Cart Session (Saat Login)
    public function restore_cart_from_db($id_customer)
    {
        $stored_cart = $this->db->where('id_customer', $id_customer)
                                ->get('keranjang')
                                ->result();

        if ($stored_cart) {
            // Hancurkan keranjang kosong/temporary saat ini agar bersih
            $this->cart->destroy();

            foreach ($stored_cart as $item) {
                $data = [
                    'id'      => $item->id_produk,
                    'qty'     => $item->qty,
                    'price'   => $item->price,
                    'name'    => $item->name,
                    'options' => json_decode($item->options, true) // Balikin JSON ke Array
                ];
                $this->cart->insert($data);
            }
        }
    }
}