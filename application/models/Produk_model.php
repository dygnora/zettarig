<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    protected $table = 'produk';

    // ==================================================
    // ================= ADMIN SIDE =====================
    // ==================================================

    // HITUNG TOTAL PRODUK (ADMIN)
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

    // LIST PRODUK + PAGINATION (ADMIN)
    public function get_paginated($limit, $offset, $keyword = null)
    {
        $this->db->select('
            p.id_produk,
            p.nama_produk,
            p.harga_jual,
            p.stok,
            p.gambar_produk,
            p.status_aktif,
            k.nama_kategori,
            b.nama_brand
        ');
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

        return $this->db
            ->order_by('p.id_produk', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // GET PRODUK BY ID (ADMIN)
    public function get_by_id($id)
    {
        return $this->db
            ->where('id_produk', $id)
            ->get($this->table)
            ->row();
    }

    // INSERT PRODUK
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // UPDATE PRODUK
    public function update($id, $data)
    {
        return $this->db
            ->where('id_produk', $id)
            ->update($this->table, $data);
    }

    // SET STATUS AKTIF / NONAKTIF
    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    // UPDATE STOK & HARGA MODAL (PEMBELIAN SUPPLIER)
    public function update_stok_dan_modal($id_produk, $qty, $harga_modal)
    {
        $this->db->set('stok', 'stok + ' . (int)$qty, false);
        $this->db->set('harga_modal', $harga_modal);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update($this->table);
    }

    // KURANGI STOK (PENJUALAN)
    public function kurangi_stok($id_produk, $qty)
    {
        $this->db->set('stok', 'stok - ' . (int)$qty, false);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update($this->table);
    }

    // ==================================================
    // PENTING: DIPAKAI PEMBELIAN SUPPLIER (ADMIN)
    // ==================================================
    public function get_all_aktif()
    {
        return $this->db
            ->select('
                id_produk,
                nama_produk,
                stok,
                harga_modal,
                harga_jual
            ')
            ->from($this->table)
            ->where('status_aktif', 1)
            ->order_by('nama_produk', 'ASC')
            ->get()
            ->result();
    }

    // ==================================================
    // ================== WEB SIDE ======================
    // ==================================================

    // COUNT PRODUK AKTIF (WEB)
    public function count_active_products($keyword = null, $kategori_id = null)
    {
        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');
        $this->db->where('p.status_aktif', 1);

        if ($kategori_id) {
            $this->db->where('p.id_kategori', $kategori_id);
        }

        if ($keyword) {
            $this->db->group_start()
                ->like('p.nama_produk', $keyword)
                ->or_like('b.nama_brand', $keyword)
                ->or_like('k.nama_kategori', $keyword)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    // LIST PRODUK AKTIF + PAGINATION (WEB)
    public function get_active_products_paginated($limit, $offset, $keyword = null, $kategori_id = null)
    {
        $this->db->select('
            p.nama_produk,
            p.slug_produk,
            p.harga_jual,
            p.stok,
            p.gambar_produk,
            k.nama_kategori,
            b.nama_brand
        ');
        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');
        $this->db->where('p.status_aktif', 1);

        if ($kategori_id) {
            $this->db->where('p.id_kategori', $kategori_id);
        }

        if ($keyword) {
            $this->db->group_start()
                ->like('p.nama_produk', $keyword)
                ->or_like('b.nama_brand', $keyword)
                ->or_like('k.nama_kategori', $keyword)
                ->group_end();
        }

        return $this->db
            ->order_by('p.nama_produk', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // DETAIL PRODUK AKTIF BERDASARKAN SLUG (WEB)
    public function get_active_by_slug($slug)
    {
        return $this->db
            ->select('p.*, k.nama_kategori, b.nama_brand')
            ->from('produk p')
            ->join('kategori_produk k', 'k.id_kategori = p.id_kategori')
            ->join('brand b', 'b.id_brand = p.id_brand')
            ->where('p.slug_produk', $slug)
            ->where('p.status_aktif', 1)
            ->limit(1)
            ->get()
            ->row();
    }

    // ==================================================
    // WRAPPER UNTUK CART (WAJIB ADA)
    // ==================================================
    public function get_by_slug($slug)
    {
        return $this->get_active_by_slug($slug);
    }
}
