<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{
    // ==================================================
    // LIST PENJUALAN (TANPA PAGINATION)
    // Dipakai jika butuh semua data (mis. export)
    // ==================================================
    public function get_all()
    {
        return $this->db
            ->select('
                p.id_penjualan,
                p.tanggal_pesanan,
                p.total_harga,
                p.metode_pembayaran,
                p.status_pesanan,
                c.nama AS nama_customer
            ')
            ->from('penjualan p')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->get()
            ->result();
    }

    // ==================================================
    // LIST PENJUALAN + PAGINATION
    // ==================================================
    public function get_paginated($limit, $offset)
    {
        return $this->db
            ->select('
                p.id_penjualan,
                p.tanggal_pesanan,
                p.total_harga,
                p.metode_pembayaran,
                p.status_pesanan,
                c.nama AS nama_customer
            ')
            ->from('penjualan p')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // ==================================================
    // DETAIL HEADER PENJUALAN
    // ==================================================
    public function get_by_id($id_penjualan)
    {
        return $this->db
            ->select('
                p.*,
                c.nama AS nama_customer,
                c.email,
                c.no_hp
            ')
            ->from('penjualan p')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where('p.id_penjualan', $id_penjualan)
            ->get()
            ->row();
    }

    // ==================================================
    // DETAIL ITEM PENJUALAN
    // ==================================================
    public function get_detail($id_penjualan)
    {
        return $this->db
            ->select('
                d.jumlah,
                d.harga_satuan,
                d.subtotal,
                pr.nama_produk
            ')
            ->from('detail_penjualan d')
            ->join('produk pr', 'pr.id_produk = d.id_produk')
            ->where('d.id_penjualan', $id_penjualan)
            ->get()
            ->result();
    }

    // ==================================================
    // TIMELINE PESANAN
    // ==================================================
    public function get_timeline($id_penjualan)
    {
        return $this->db
            ->from('timeline_pesanan')
            ->where('id_penjualan', $id_penjualan)
            ->order_by('waktu', 'ASC')
            ->get()
            ->result();
    }

    // ==================================================
    // HITUNG TOTAL PENJUALAN (PAGINATION)
    // ==================================================
    public function count_all()
    {
        return $this->db->count_all_results('penjualan');
    }

    // ==================================================
    // TOTAL PENDAPATAN (DASHBOARD)
    // ==================================================
    public function total_pendapatan()
    {
        return $this->db
            ->select_sum('total_harga')
            ->get('penjualan')
            ->row()
            ->total_harga;
    }

    // ==================================================
    // HITUNG PESANAN MENUNGGU
    // ==================================================
    public function count_menunggu()
    {
        return $this->db
            ->where('status_pesanan', 'dibuat')
            ->count_all_results('penjualan');
    }

    // ==================================================
    // RIWAYAT PESANAN CUSTOMER (WEB)
    // ==================================================
    public function get_by_customer($customer_id)
    {
        return $this->db
            ->select('
                p.id_penjualan,
                p.tanggal_pesanan,
                p.total_harga,
                p.status_pesanan
            ')
            ->from('penjualan p')
            ->where('p.id_customer', $customer_id)
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->get()
            ->result();
    }

    // ==================================================
    // DETAIL PESANAN CUSTOMER (WEB)
    // ==================================================
    public function get_detail_by_customer($id_penjualan, $customer_id)
    {
        // header pesanan
        $pesanan = $this->db
            ->where('id_penjualan', $id_penjualan)
            ->where('id_customer', $customer_id)
            ->limit(1)
            ->get('penjualan')
            ->row();

        if (!$pesanan) {
            return null;
        }

        // detail item
        $pesanan->items = $this->db
            ->select('
                d.qty,
                d.harga_jual,
                d.subtotal,
                pr.nama_produk
            ')
            ->from('detail_penjualan d')
            ->join('produk pr', 'pr.id_produk = d.id_produk')
            ->where('d.id_penjualan', $id_penjualan)
            ->get()
            ->result();

        return $pesanan;
    }


}
