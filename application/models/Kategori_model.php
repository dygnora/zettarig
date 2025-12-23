<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model
{
    protected $table = 'kategori_produk';

    // ==================================================
    // FUNGSI LAMA (ADMIN PANEL) - TETAP AMAN
    // ==================================================

    public function count_all($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_kategori', $keyword);
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_paginated($limit, $offset, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_kategori', $keyword);
        }

        return $this->db
            ->order_by('id_kategori', 'ASC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('id_kategori', $id)
            ->get($this->table)
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id_kategori', $id)
            ->update($this->table, $data);
    }

    // ==================================================
    // FUNGSI BARU (FRONTEND / WEB)
    // ==================================================

    // 1. Ambil semua kategori aktif untuk dropdown/menu
    public function get_all_active()
    {
        return $this->db
            ->where('status_aktif', 1)
            ->order_by('nama_kategori', 'ASC')
            ->get($this->table)
            ->result();
    }

    // 2. Ambil kategori berdasarkan slug (nama) untuk filter URL
    // Digunakan oleh controller Produk.php
    public function get_by_slug($slug)
    {
        // Karena di database tidak ada kolom 'slug', kita cari berdasarkan 'nama_kategori'.
        // MySQL biasanya case-insensitive, jadi 'processor' akan cocok dengan 'Processor'.
        
        return $this->db
            ->where('nama_kategori', $slug)
            ->where('status_aktif', 1) // Hanya cari kategori yang aktif
            ->get($this->table)
            ->row();
    }
}