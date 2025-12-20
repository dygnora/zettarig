<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    // ==================================================
    // HITUNG TOTAL DATA (UNTUK PAGINATION)
    // ==================================================
    public function count_all()
    {
        return $this->db->count_all_results('pembayaran_transfer');
    }

    // ==================================================
    // LIST PEMBAYARAN TRANSFER (PAGINATION)
    // ==================================================
    public function get_paginated($limit, $offset)
    {
        return $this->db
            ->select('
                pt.id_pembayaran,
                pt.jumlah_dibayar,
                pt.status_verifikasi,
                pt.tanggal_upload,
                pt.bukti_transfer,
                p.id_penjualan,
                p.status_pesanan,
                c.nama AS nama_customer
            ')
            ->from('pembayaran_transfer pt')
            ->join('penjualan p', 'p.id_penjualan = pt.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('pt.tanggal_upload', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    // ==================================================
    // DETAIL SATU PEMBAYARAN
    // ==================================================
    public function get_by_id($id_pembayaran)
    {
        return $this->db
            ->select('
                pt.*,
                p.id_penjualan,
                p.total_harga,
                p.status_pesanan,
                p.tanggal_pesanan,
                c.nama AS nama_customer,
                c.email,
                c.no_hp
            ')
            ->from('pembayaran_transfer pt')
            ->join('penjualan p', 'p.id_penjualan = pt.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where('pt.id_pembayaran', $id_pembayaran)
            ->get()
            ->row();
    }

    // ==================================================
    // PROSES VERIFIKASI (LOGIC UTAMA)
    // ==================================================
    public function proses_verifikasi($id_pembayaran, $id_penjualan, $status_verifikasi)
    {
        // 1. SET TIMEZONE KE WIB (PENTING AGAR JAM SESUAI)
        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = date('Y-m-d H:i:s');

        // 2. UPDATE STATUS DI TABEL PEMBAYARAN_TRANSFER
        $data_bayar = [
            'status_verifikasi'  => $status_verifikasi,
            'tanggal_verifikasi' => $waktu_sekarang // Pakai waktu WIB
        ];
        $this->db->where('id_pembayaran', $id_pembayaran)
                 ->update('pembayaran_transfer', $data_bayar);

        // 3. LOGIKA JIKA DITERIMA ATAU DITOLAK
        if ($status_verifikasi == 'diterima') {
            
            // A. Update Status Pesanan jadi 'diproses'
            $this->db->where('id_penjualan', $id_penjualan)
                     ->update('penjualan', ['status_pesanan' => 'diproses']);

            // B. Masukkan Timeline 1: Pembayaran Diterima (Warna Hijau)
            $this->db->insert('timeline_pesanan', [
                'id_penjualan' => $id_penjualan,
                'status_tahap' => 'Pembayaran Diterima', 
                'waktu'        => $waktu_sekarang, // WIB
                'catatan'      => 'Bukti transfer valid. Pembayaran diterima.'
            ]);

            // C. Masukkan Timeline 2: Pesanan Diproses (Otomatis lanjut)
            // Kita tambahkan 1 detik agar urutannya pasti di bawah "Pembayaran Diterima"
            $waktu_proses = date('Y-m-d H:i:s', strtotime($waktu_sekarang) + 1);

            $this->db->insert('timeline_pesanan', [
                'id_penjualan' => $id_penjualan,
                'status_tahap' => 'Pesanan Diproses',
                'waktu'        => $waktu_proses, // WIB + 1 detik
                'catatan'      => 'Pesanan sedang disiapkan oleh admin.'
            ]);

        } else {
            // JIKA DITOLAK
            $this->db->where('id_penjualan', $id_penjualan)
                     ->update('penjualan', ['status_pesanan' => 'menunggu_pembayaran']);

            $this->db->insert('timeline_pesanan', [
                'id_penjualan' => $id_penjualan,
                'status_tahap' => 'Pembayaran Ditolak',
                'waktu'        => $waktu_sekarang, // WIB
                'catatan'      => 'Bukti tidak valid. Silakan upload ulang.'
            ]);
        }
    }
}