<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    protected $table = 'produk';

    // ==================================================
    // HITUNG TOTAL PRODUK
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

    // ==================================================
    // LIST PRODUK + JOIN KATEGORI & BRAND
    // ==================================================
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

    // ==================================================
    // GET BY ID
    // ==================================================
    public function get_by_id($id)
    {
        return $this->db
            ->where('id_produk', $id)
            ->get($this->table)
            ->row();
    }

    // ==================================================
    // INSERT
    // ==================================================
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ==================================================
    // UPDATE
    // ==================================================
    public function update($id, $data)
    {
        return $this->db
            ->where('id_produk', $id)
            ->update($this->table, $data);
    }

    // ==================================================
    // SET STATUS
    // ==================================================
    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    // ==================================================
    // UPDATE STOK & HARGA MODAL
    // (dipanggil dari pembelian supplier)
    // ==================================================
    public function update_stok_dan_modal($id_produk, $qty, $harga_modal)
    {
        $this->db->set('stok', 'stok + '.$qty, false);
        $this->db->set('harga_modal', $harga_modal);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update($this->table);
    }

    // ==================================================
    // KURANGI STOK (SAAT PENJUALAN)
    // ==================================================
    public function kurangi_stok($id_produk, $qty)
    {
        $this->db->set('stok', 'stok - '.$qty, false);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update($this->table);
    }

    // ==================================================
    // PRODUK AKTIF (UNTUK TRANSAKSI)
    // ==================================================
    public function get_all_aktif()
    {
        return $this->db
            ->where('status_aktif', 1)
            ->order_by('nama_produk', 'ASC')
            ->get($this->table)
            ->result();
    }
}
