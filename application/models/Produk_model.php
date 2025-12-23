<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    protected $table = 'produk';

    // ==================================================
    // ================= ADMIN SIDE =====================
    // ==================================================

    // Hitung total produk (dengan optional keyword)
    public function count_all($keyword = null)
    {
        $this->db->from('produk p')
                 ->join('kategori_produk k', 'k.id_kategori = p.id_kategori')
                 ->join('brand b', 'b.id_brand = p.id_brand');

        if ($keyword) {
            $this->db->group_start()
                     ->like('p.nama_produk', $keyword)
                     ->or_like('k.nama_kategori', $keyword)
                     ->or_like('b.nama_brand', $keyword)
                     ->group_end();
        }

        return $this->db->count_all_results();
    }

    // Ambil data produk (pagination + search)
    public function get_paginated($limit, $offset, $keyword = null)
    {
        $this->db->select('p.*, k.nama_kategori, b.nama_brand')
                 ->from('produk p')
                 ->join('kategori_produk k', 'k.id_kategori = p.id_kategori')
                 ->join('brand b', 'b.id_brand = p.id_brand');

        if ($keyword) {
            $this->db->group_start()
                     ->like('p.nama_produk', $keyword)
                     ->or_like('k.nama_kategori', $keyword)
                     ->or_like('b.nama_brand', $keyword)
                     ->group_end();
        }

        return $this->db->order_by('p.id_produk', 'DESC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    // Ambil produk by ID (dipakai admin & validasi stok)
    public function get_by_id($id)
    {
        return $this->db->where('id_produk', $id)
                        ->get($this->table)
                        ->row();
    }

    // Insert produk baru
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update produk
    public function update($id, $data)
    {
        return $this->db->where('id_produk', $id)
                        ->update($this->table, $data);
    }

    // Aktif / Nonaktif produk
    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    // Tambah stok + update harga modal (pembelian supplier)
    public function update_stok_dan_modal($id_produk, $qty, $harga_modal)
    {
        $this->db->set('stok', 'stok + '.(int)$qty, false)
                 ->set('harga_modal', $harga_modal)
                 ->where('id_produk', $id_produk);

        return $this->db->update($this->table);
    }

    // Kurangi stok (penjualan)
    public function kurangi_stok($id_produk, $qty)
    {
        $this->db->set('stok', 'stok - '.(int)$qty, false)
                 ->where('id_produk', $id_produk);

        return $this->db->update($this->table);
    }

    // Ambil semua produk aktif (dropdown, helper)
    public function get_all_aktif()
    {
        return $this->db->where('status_aktif', 1)
                        ->order_by('nama_produk', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    // ==================================================
    // ================= WEB SIDE =======================
    // ==================================================

    // Ambil produk by slug (tanpa cek status)
    public function get_by_slug($slug)
    {
        return $this->db->select('p.*, b.nama_brand')
                        ->from('produk p')
                        ->join('brand b', 'b.id_brand = p.id_brand', 'left')
                        ->where('p.slug_produk', $slug)
                        ->get()
                        ->row();
    }

    // Filter terpusat (private)
    private function _apply_web_filters($filters)
    {
        $this->db->from('produk p')
                 ->join('kategori_produk k', 'k.id_kategori = p.id_kategori')
                 ->join('brand b', 'b.id_brand = p.id_brand')
                 ->where('p.status_aktif', 1);

        if (!empty($filters['keyword'])) {
            $this->db->group_start()
                     ->like('p.nama_produk', $filters['keyword'])
                     ->or_like('b.nama_brand', $filters['keyword'])
                     ->or_like('k.nama_kategori', $filters['keyword'])
                     ->group_end();
        }

        if (!empty($filters['kategori'])) {
            $this->db->where('p.id_kategori', $filters['kategori']);
        }

        if (!empty($filters['min_price'])) {
            $this->db->where('p.harga_jual >=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $this->db->where('p.harga_jual <=', $filters['max_price']);
        }
    }

    // Hitung produk (frontend filter)
    public function count_filtered($filters = [])
    {
        $this->_apply_web_filters($filters);
        return $this->db->count_all_results();
    }

    // Ambil produk (frontend filter + pagination)
    public function get_filtered($limit, $offset, $filters = [])
    {
        $this->db->select('p.*, k.nama_kategori, b.nama_brand');
        $this->_apply_web_filters($filters);

        return $this->db->order_by('p.id_produk', 'DESC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    // Detail produk aktif (halaman detail)
    public function get_active_by_slug($slug)
    {
        return $this->db->select('p.*, k.nama_kategori, b.nama_brand')
                        ->from('produk p')
                        ->join('kategori_produk k', 'k.id_kategori = p.id_kategori')
                        ->join('brand b', 'b.id_brand = p.id_brand')
                        ->where('p.slug_produk', $slug)
                        ->where('p.status_aktif', 1)
                        ->get()
                        ->row();
    }

    // Produk unggulan / New Arrivals (Homepage)
    public function get_featured_products($limit = 8)
    {
        return $this->db->where('status_aktif', 1)
                        ->order_by('tanggal_dibuat', 'DESC')
                        ->limit($limit)
                        ->get($this->table)
                        ->result();
    }

    // ==================================================
    // ============== PERSISTENT CART ===================
    // ==================================================

    // Simpan cart session ke database
    public function save_cart_to_db($id_customer)
    {
        $this->db->where('id_customer', $id_customer)->delete('keranjang');

        foreach ($this->cart->contents() as $item) {
            $this->db->insert('keranjang', [
                'id_customer' => $id_customer,
                'id_produk'   => $item['id'],
                'qty'         => $item['qty'],
                'price'       => $item['price'],
                'name'        => $item['name'],
                'options'     => json_encode($item['options'])
            ]);
        }
    }

    // Restore cart dari database saat login
    public function restore_cart_from_db($id_customer)
    {
        $items = $this->db->where('id_customer', $id_customer)
                          ->get('keranjang')
                          ->result();

        if ($items) {
            $this->cart->destroy();

            foreach ($items as $item) {
                $this->cart->insert([
                    'id'      => $item->id_produk,
                    'qty'     => $item->qty,
                    'price'   => $item->price,
                    'name'    => $item->name,
                    'options' => json_decode($item->options, true)
                ]);
            }
        }
    }
}
