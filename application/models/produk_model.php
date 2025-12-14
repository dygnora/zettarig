<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    protected $table = 'produk';

    // ===============================
    // COUNT
    // ===============================
    public function count_all($keyword = null)
    {
        $this->db->from($this->table);
        $this->db->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori');
        $this->db->join('brand', 'brand.id_brand = produk.id_brand');

        if ($keyword) {
            $this->db->group_start()
                ->like('produk.nama_produk', $keyword)
                ->or_like('kategori_produk.nama_kategori', $keyword)
                ->or_like('brand.nama_brand', $keyword)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    // ===============================
    // LIST PAGINATION
    // ===============================
    public function get_paginated($limit, $offset, $keyword = null)
    {
        $this->db->select('
            produk.id_produk,
            produk.nama_produk,
            produk.harga_jual,
            produk.status_aktif,
            kategori_produk.nama_kategori,
            brand.nama_brand
        ');
        $this->db->from($this->table);
        $this->db->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori');
        $this->db->join('brand', 'brand.id_brand = produk.id_brand');

        if ($keyword) {
            $this->db->group_start()
                ->like('produk.nama_produk', $keyword)
                ->or_like('kategori_produk.nama_kategori', $keyword)
                ->or_like('brand.nama_brand', $keyword)
                ->group_end();
        }

        return $this->db
            ->order_by('produk.id_produk', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // ===============================
    // GET BY ID
    // ===============================
    public function get_by_id($id)
    {
        return $this->db
            ->where('id_produk', $id)
            ->get($this->table)
            ->row();
    }

    // ===============================
    // INSERT
    // ===============================
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update($id, $data)
    {
        return $this->db
            ->where('id_produk', $id)
            ->update($this->table, $data);
    }

    // ===============================
    // STATUS
    // ===============================
    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    public function update_stok_dan_modal($id_produk, $qty, $harga_modal)
    {
        $this->db->set('stok', 'stok + '.$qty, FALSE);
        $this->db->set('harga_modal', $harga_modal);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update('produk');
    }

    public function get_all_aktif()
    {
        return $this->db
            ->where('status_aktif', 1)
            ->get('produk')
            ->result();
    }


}
