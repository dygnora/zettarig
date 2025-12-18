<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cod_model extends CI_Model
{
    // ==================================================
    // HITUNG TOTAL DATA COD (PAGINATION)
    // ==================================================
    public function count_all()
    {
        return $this->db->count_all_results('pembayaran_cod');
    }

    // ==================================================
    // LIST COD + PAGINATION
    // ==================================================
    public function get_paginated($limit, $offset)
    {
        return $this->db
            ->select('
                pc.id_cod,
                pc.dp_dibayar,
                pc.status_dp,
                pc.status_pelunasan,
                p.id_penjualan,
                p.total_harga,
                p.tanggal_pesanan,
                c.nama AS nama_customer
            ')
            ->from('pembayaran_cod pc')
            ->join('penjualan p', 'p.id_penjualan = pc.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // ==================================================
    // LIST SEMUA COD (TANPA PAGINATION)
    // ==================================================
    public function get_all()
    {
        return $this->db
            ->select('
                pc.id_cod,
                pc.dp_dibayar,
                pc.status_dp,
                pc.status_pelunasan,
                p.id_penjualan,
                p.total_harga,
                p.tanggal_pesanan,
                c.nama AS nama_customer
            ')
            ->from('pembayaran_cod pc')
            ->join('penjualan p', 'p.id_penjualan = pc.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->get()
            ->result();
    }

    // ==================================================
    // DETAIL COD
    // ==================================================
    public function get_by_id($id)
    {
        return $this->db
            ->select('
                pc.*,
                p.total_harga,
                p.tanggal_pesanan,
                c.nama AS nama_customer
            ')
            ->from('pembayaran_cod pc')
            ->join('penjualan p', 'p.id_penjualan = pc.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where('pc.id_cod', $id)
            ->get()
            ->row();
    }

    // ==================================================
    // VERIFIKASI DP
    // ==================================================
    public function verifikasi_dp($id, $status)
    {
        return $this->db
            ->where('id_cod', $id)
            ->update('pembayaran_cod', [
                'status_dp' => $status
            ]);
    }

    // ==================================================
    // PELUNASAN COD
    // ==================================================
    public function pelunasan($id)
    {
        return $this->db
            ->where('id_cod', $id)
            ->update('pembayaran_cod', [
                'status_pelunasan' => 'lunas'
            ]);
    }
}
