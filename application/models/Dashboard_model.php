<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    // ==================================================
    // COUNT DATA (INFO BOX DASHBOARD)
    // ==================================================
    public function count_produk()
    {
        return $this->db->count_all('produk');
    }

    public function count_customer()
    {
        return $this->db->count_all('customer');
    }

    public function count_supplier()
    {
        return $this->db->count_all('supplier');
    }

    public function count_stok_menipis($batas = 5)
    {
        return $this->db
            ->where('stok <=', $batas)
            ->count_all_results('produk');
    }

    // ==================================================
    // PRODUK STOK MENIPIS (DETAIL)
    // ==================================================
    public function get_produk_stok_menipis($batas = 5)
    {
        return $this->db
            ->select('nama_produk, stok')
            ->from('produk')
            ->where('stok <=', $batas)
            ->order_by('stok', 'ASC')
            ->limit(5)
            ->get()
            ->result();
    }

    // ==================================================
    // GRAFIK BULANAN (PENDAPATAN vs PEMBELIAN)
    // ==================================================
    public function get_pendapatan_vs_pembelian_bulanan()
    {
        $sql = "
            SELECT
                tahun,
                bulan_angka,
                SUM(total_pendapatan) AS total_pendapatan,
                SUM(total_pembelian)  AS total_pembelian
            FROM (
                -- PENDAPATAN (PENJUALAN SELESAI)
                SELECT
                    YEAR(p.tanggal_pesanan)  AS tahun,
                    MONTH(p.tanggal_pesanan) AS bulan_angka,
                    SUM(p.total_harga)       AS total_pendapatan,
                    0                        AS total_pembelian
                FROM penjualan p
                WHERE p.status_pesanan = 'selesai'
                GROUP BY YEAR(p.tanggal_pesanan), MONTH(p.tanggal_pesanan)

                UNION ALL

                -- PEMBELIAN (DARI SUPPLIER)
                SELECT
                    YEAR(ps.tanggal_pembelian)  AS tahun,
                    MONTH(ps.tanggal_pembelian) AS bulan_angka,
                    0                           AS total_pendapatan,
                    SUM(dps.subtotal)           AS total_pembelian
                FROM detail_pembelian_supplier dps
                JOIN pembelian_supplier ps
                  ON ps.id_pembelian = dps.id_pembelian
                GROUP BY YEAR(ps.tanggal_pembelian), MONTH(ps.tanggal_pembelian)
            ) data
            GROUP BY tahun, bulan_angka
            ORDER BY tahun ASC, bulan_angka ASC
        ";

        return $this->db->query($sql)->result();
    }

    // ==================================================
    // TOTAL REVENUE & COST (SUMMARY)
    // ==================================================
    public function get_total_revenue()
    {
        $row = $this->db
            ->select('SUM(total_harga) AS total')
            ->from('penjualan')
            ->where('status_pesanan', 'selesai')
            ->get()
            ->row();

        return (int) ($row->total ?? 0);
    }

    public function get_total_cost()
    {
        $row = $this->db
            ->select('SUM(subtotal) AS total')
            ->from('detail_pembelian_supplier')
            ->get()
            ->row();

        return (int) ($row->total ?? 0);
    }

    // ==================================================
    // PESANAN TERBARU (LIST DI DASHBOARD UTAMA)
    // ==================================================
    public function get_latest_orders($limit = 5)
    {
        return $this->db
            ->select('
                p.id_penjualan,
                p.total_harga,
                p.metode_pembayaran,
                p.status_pesanan,
                c.nama AS nama_customer
            ')
            ->from('penjualan p')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // ==================================================
    // [UPDATED] NOTIFIKASI NAVBAR: HITUNG JUMLAH
    // ==================================================
    public function count_pesanan_baru()
    {
        return $this->db
            ->where_in('status_pesanan', ['dibuat', 'menunggu_verifikasi'])
            ->count_all_results('penjualan');
    }

    // ==================================================
    // [UPDATED] NOTIFIKASI NAVBAR: LIST DATA
    // ==================================================
    public function get_pesanan_baru($limit = 5)
    {
        // Perbaikan: Hapus komentar di dalam string select
        return $this->db
            ->select('
                p.id_penjualan,
                p.tanggal_pesanan,
                p.total_harga,
                p.status_pesanan,
                c.nama AS nama_customer
            ')
            ->from('penjualan p')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where_in('p.status_pesanan', ['dibuat', 'menunggu_verifikasi'])
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}