<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model
{
    protected $table = 'kategori_produk';

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

    // ✅ INI YANG BARU
    public function get_all_active()
    {
        return $this->db
            ->where('status_aktif', 1)
            ->order_by('nama_kategori', 'ASC')
            ->get($this->table)
            ->result();
    }
}
