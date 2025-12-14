<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model
{
    protected $table = 'brand';

    public function count_all($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_brand', $keyword);
        }

        return $this->db->count_all_results($this->table);
    }

    public function get_paginated($limit, $offset, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_brand', $keyword);
        }

        return $this->db
            ->order_by('id_brand', 'ASC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('id_brand', $id)
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
            ->where('id_brand', $id)
            ->update($this->table, $data);
    }

    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    public function get_all_active()
    {
        return $this->db
            ->where('status_aktif', 1)
            ->order_by('nama_brand', 'ASC')
            ->get('brand')
            ->result();
    }

}
