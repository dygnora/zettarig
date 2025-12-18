<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_supplier_model extends CI_Model
{
    protected $table = 'pembelian_supplier';

    // ==================================================
    // HITUNG TOTAL PEMBELIAN (PAGINATION)
    // ==================================================
    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    // ==================================================
    // LIST PEMBELIAN + PAGINATION
    // ==================================================
    public function get_paginated($limit, $offset)
    {
        return $this->db
            ->select('pembelian_supplier.*, supplier.nama_supplier')
            ->from($this->table)
            ->join('supplier', 'supplier.id_supplier = pembelian_supplier.id_supplier')
            ->order_by('id_pembelian', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // ==================================================
    // LIST SEMUA PEMBELIAN (TANPA PAGINATION)
    // ==================================================
    public function get_all_with_supplier()
    {
        return $this->db
            ->select('pembelian_supplier.*, supplier.nama_supplier')
            ->from($this->table)
            ->join('supplier', 'supplier.id_supplier = pembelian_supplier.id_supplier')
            ->order_by('id_pembelian', 'DESC')
            ->get()
            ->result();
    }

    // ==================================================
    // INSERT PEMBELIAN
    // ==================================================
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // ==================================================
    // DETAIL PEMBELIAN
    // ==================================================
    public function get_by_id($id)
    {
        return $this->db
            ->select('pembelian_supplier.*, supplier.nama_supplier')
            ->from($this->table)
            ->join('supplier', 'supplier.id_supplier = pembelian_supplier.id_supplier')
            ->where('id_pembelian', $id)
            ->get()
            ->row();
    }
}
