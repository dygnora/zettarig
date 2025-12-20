<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{
    // ==================================================
    // LIST PENJUALAN (ADMIN)
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
    // DETAIL ITEM PRODUK
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
    // MANAJEMEN STATUS & TIMELINE (FIX TIMEZONE)
    // ==================================================
    
    // Update Status Pesanan
    public function update_status($id, $status)
    {
        return $this->db
            ->where('id_penjualan', $id)
            ->update('penjualan', ['status_pesanan' => $status]);
    }

    // Insert Timeline Baru
    public function add_timeline($id, $tahap, $catatan = null)
    {
        // --- FIX TIMEZONE: PAKSA KE WIB ---
        date_default_timezone_set('Asia/Jakarta');
        // ----------------------------------

        return $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id,
            'status_tahap' => $tahap,
            'waktu'        => date('Y-m-d H:i:s'), // Sekarang sudah WIB
            'catatan'      => $catatan
        ]);
    }

    // Ambil Timeline
    public function get_timeline($id_penjualan)
    {
        return $this->db
            ->from('timeline_pesanan')
            ->where('id_penjualan', $id_penjualan)
            ->order_by('waktu', 'ASC') 
            ->order_by('id_timeline', 'ASC') 
            ->get()
            ->result();
    }

    // ==================================================
    // DASHBOARD & UTILITY
    // ==================================================
    public function count_all()
    {
        return $this->db->count_all_results('penjualan');
    }

    public function total_pendapatan()
    {
        return $this->db
            ->select_sum('total_harga')
            ->get('penjualan')
            ->row()
            ->total_harga;
    }

    public function count_menunggu()
    {
        return $this->db
            ->where('status_pesanan', 'dibuat')
            ->count_all_results('penjualan');
    }

    // ==================================================
    // SISI CUSTOMER (WEB)
    // ==================================================
    public function get_by_customer($customer_id)
    {
        return $this->db
            ->select('id_penjualan, tanggal_pesanan, total_harga, status_pesanan')
            ->from('penjualan')
            ->where('id_customer', $customer_id)
            ->order_by('tanggal_pesanan', 'DESC')
            ->get()
            ->result();
    }

    public function get_detail_by_customer($id_penjualan, $customer_id)
    {
        $pesanan = $this->db
            ->select('p.*')
            ->from('penjualan p')
            ->where('p.id_penjualan', $id_penjualan)
            ->where('p.id_customer', $customer_id)
            ->limit(1)
            ->get()
            ->row();

        if (!$pesanan) return null;

        $pesanan->items = $this->db
            ->select('d.*, pr.nama_produk')
            ->from('detail_penjualan d')
            ->join('produk pr', 'pr.id_produk = d.id_produk')
            ->where('d.id_penjualan', $id_penjualan)
            ->get()
            ->result();

        return $pesanan;
    }
}