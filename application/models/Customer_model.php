<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    protected $table = 'customer';

    // ===============================
    // COUNT
    // ===============================
    public function count_all($keyword = null)
    {
        if ($keyword) {
            $this->db->group_start()
                ->like('nama', $keyword)
                ->or_like('username', $keyword)
                ->or_like('email', $keyword)
                ->group_end();
        }

        return $this->db->count_all_results($this->table);
    }

    // ===============================
    // LIST PAGINATION
    // ===============================
    public function get_paginated($limit, $offset, $keyword = null)
    {
        if ($keyword) {
            $this->db->group_start()
                ->like('nama', $keyword)
                ->or_like('username', $keyword)
                ->or_like('email', $keyword)
                ->group_end();
        }

        return $this->db
            ->order_by('id_customer', 'ASC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result();
    }

    // ===============================
    // GET BY ID
    // ===============================
    public function get_by_id($id)
    {
        return $this->db
            ->where('id_customer', $id)
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
            ->where('id_customer', $id)
            ->update($this->table, $data);
    }

    // ===============================
    // STATUS
    // ===============================
    public function set_status($id, $status)
    {
        return $this->update($id, ['status_aktif' => $status]);
    }

    // ===============================
    // COD PERMISSION
    // ===============================
    public function set_cod_allowed($id, $status)
    {
        return $this->update($id, ['is_cod_allowed' => $status]);
    }

    // ==================================================
    // ================= WEB AUTH =======================
    // ==================================================

    // GET CUSTOMER BY EMAIL (LOGIN)
    public function get_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->limit(1)
            ->get($this->table)
            ->row();
    }
}
