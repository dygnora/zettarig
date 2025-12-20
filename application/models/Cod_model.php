<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cod_model extends CI_Model
{
    // ==================================================
    // HITUNG TOTAL DATA (PAGINATION)
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
                pc.dp_wajib,
                pc.dp_dibayar,
                pc.sisa_pembayaran,
                pc.status_dp,
                pc.status_pelunasan,
                p.id_penjualan,
                p.total_harga,
                p.tanggal_pesanan,
                p.status_pesanan,
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
    // DETAIL COD
    // ==================================================
    public function get_by_id($id)
    {
        return $this->db
            ->select('
                pc.*,
                p.id_penjualan,
                p.total_harga,
                p.tanggal_pesanan,
                p.status_pesanan,
                c.nama AS nama_customer,
                c.no_hp,
                c.alamat
            ')
            ->from('pembayaran_cod pc')
            ->join('penjualan p', 'p.id_penjualan = pc.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where('pc.id_cod', $id)
            ->get()
            ->row();
    }

    // ==================================================
    // [LOGIC UTAMA] VERIFIKASI DP
    // ==================================================
    public function verifikasi_dp($id_cod, $status)
    {
        // Ambil data untuk referensi ID Penjualan
        $cod = $this->db->get_where('pembayaran_cod', ['id_cod' => $id_cod])->row();
        if (!$cod) return false;

        $id_penjualan = $cod->id_penjualan;

        // Set Waktu
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        // --- MULAI TRANSAKSI ---
        $this->db->trans_start();

        // 1. Update Status DP di tabel pembayaran_cod
        $this->db->where('id_cod', $id_cod)
                 ->update('pembayaran_cod', ['status_dp' => $status]);

        // 2. Logika Status Pesanan & Timeline
        if ($status == 'diterima') {
            
            // Jika DP Diterima -> Pesanan jadi 'diproses'
            $this->db->where('id_penjualan', $id_penjualan)
                     ->update('penjualan', ['status_pesanan' => 'diproses']);
            
            // Catat Timeline
            $this->db->insert('timeline_pesanan', [
                'id_penjualan' => $id_penjualan,
                'status_tahap' => 'DP COD Diterima',
                'waktu'        => $now,
                'catatan'      => 'DP sebesar Rp ' . number_format($cod->dp_dibayar) . ' telah diverifikasi.'
            ]);

        } else {
            // Jika DP Ditolak -> Pesanan balik ke 'menunggu_pembayaran' (atau dibuat)
            $this->db->where('id_penjualan', $id_penjualan)
                     ->update('penjualan', ['status_pesanan' => 'menunggu_pembayaran']);

            // Catat Timeline
            $this->db->insert('timeline_pesanan', [
                'id_penjualan' => $id_penjualan,
                'status_tahap' => 'DP COD Ditolak',
                'waktu'        => $now,
                'catatan'      => 'Bukti DP tidak valid. Silakan upload ulang.'
            ]);
        }

        $this->db->trans_complete(); 
        // --- SELESAI TRANSAKSI ---
        
        return $this->db->trans_status();
    }

    // ==================================================
    // [LOGIC UTAMA] PELUNASAN (BARANG SAMPAI)
    // ==================================================
    public function pelunasan($id_cod)
    {
        $cod = $this->db->get_where('pembayaran_cod', ['id_cod' => $id_cod])->row();
        if (!$cod) return false;

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $this->db->trans_start();

        // 1. Update COD jadi Lunas
        $this->db->where('id_cod', $id_cod)
                 ->update('pembayaran_cod', ['status_pelunasan' => 'lunas']);

        // 2. Update Pesanan jadi Selesai
        $this->db->where('id_penjualan', $cod->id_penjualan)
                 ->update('penjualan', ['status_pesanan' => 'selesai']);

        // 3. Catat Timeline 1: Pelunasan
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $cod->id_penjualan,
            'status_tahap' => 'COD Lunas',
            'waktu'        => $now,
            'catatan'      => 'Pembayaran sisa sebesar Rp ' . number_format($cod->sisa_pembayaran) . ' diterima kurir.'
        ]);

        // 4. Catat Timeline 2: Selesai
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $cod->id_penjualan,
            'status_tahap' => 'Pesanan Selesai',
            'waktu'        => date('Y-m-d H:i:s', strtotime($now) + 1),
            'catatan'      => 'Transaksi selesai.'
        ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}