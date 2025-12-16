<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    protected $table = 'produk';

    // ==================================================
    // HITUNG TOTAL PRODUK (UNTUK PAGINATION)
    // ==================================================
    public function count_all($keyword = null)
    {
        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');
        $this->db->join('supplier s', 's.id_supplier = p.id_supplier', 'left');

        if ($keyword) {
            $this->db->group_start()
                ->like('p.nama_produk', $keyword)
                ->or_like('k.nama_kategori', $keyword)
                ->or_like('b.nama_brand', $keyword)
                ->or_like('s.nama_supplier', $keyword)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    // ==================================================
    // LIST PRODUK (JOIN KATEGORI + BRAND + SUPPLIER)
    // ==================================================
    public function get_paginated($limit, $offset, $keyword = null)
    {
        $this->db->select('
            p.id_produk,
            p.nama_produk,
            p.harga_jual,
            p.gambar_produk,
            p.status_aktif,

            k.nama_kategori,
            b.nama_brand,
            s.nama_supplier
        ');

        $this->db->from('produk p');
        $this->db->join('kategori_produk k', 'k.id_kategori = p.id_kategori');
        $this->db->join('brand b', 'b.id_brand = p.id_brand');
        $this->db->join('supplier s', 's.id_supplier = p.id_supplier', 'left');

        if ($keyword) {
            $this->db->group_start()
                ->like('p.nama_produk', $keyword)
                ->or_like('k.nama_kategori', $keyword)
                ->or_like('b.nama_brand', $keyword)
                ->or_like('s.nama_supplier', $keyword)
                ->group_end();
        }

        return $this->db
            ->order_by('p.id_produk', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // ==================================================
    // AMBIL PRODUK BERDASARKAN ID
    // ==================================================
    public function get_by_id($id)
    {
        return $this->db
            ->where('id_produk', $id)
            ->get($this->table)
            ->row();
    }

    // ==================================================
    // INSERT PRODUK BARU
    // ==================================================
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ==================================================
    // UPDATE DATA PRODUK
    // ==================================================
    public function update($id, $data)
    {
        return $this->db
            ->where('id_produk', $id)
            ->update($this->table, $data);
    }

    // ==================================================
    // AKTIF / NONAKTIF PRODUK
    // ==================================================
    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    // ==================================================
    // UPDATE STOK + HARGA MODAL (DARI PEMBELIAN SUPPLIER)
    // ==================================================
    public function update_stok_dan_modal($id_produk, $qty, $harga_modal)
    {
        $this->db->set('stok', 'stok + '.$qty, false);
        $this->db->set('harga_modal', $harga_modal);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update('produk');
    }

    // ==================================================
    // AMBIL PRODUK AKTIF (UNTUK TRANSAKSI)
    // ==================================================
    public function get_all_aktif()
    {
        return $this->db
            ->where('status_aktif', 1)
            ->get('produk')
            ->result();
    }
}
