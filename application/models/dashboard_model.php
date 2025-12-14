<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    // ================= COUNT =================
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

    // ================= STOK MENIPIS =================
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

    // ================= GRAFIK PENDAPATAN =================
    public function get_pendapatan_bulanan()
    {
        return $this->db
            ->select("
                YEAR(tanggal_pesanan) AS tahun,
                MONTH(tanggal_pesanan) AS bulan_angka,
                SUM(total_harga) AS total
            ")
            ->from('penjualan')
            ->where('status_pesanan', 'selesai')
            ->where('tanggal_pesanan >=', date('Y-m-01', strtotime('-11 months')))
            ->group_by([
                'YEAR(tanggal_pesanan)',
                'MONTH(tanggal_pesanan)'
            ])
            ->order_by('YEAR(tanggal_pesanan)', 'ASC')
            ->order_by('MONTH(tanggal_pesanan)', 'ASC')
            ->get()
            ->result();
    }

    // ================= TOTAL UANG =================
    public function get_total_revenue()
    {
        $row = $this->db
            ->select('SUM(total_harga) AS total')
            ->from('penjualan')
            ->where('status_pesanan', 'selesai')
            ->get()
            ->row();

        return $row->total ?? 0;
    }

    public function get_total_cost()
    {
        $row = $this->db
            ->select('SUM(subtotal) AS total')
            ->from('detail_pembelian_supplier')
            ->get()
            ->row();

        return $row->total ?? 0;
    }

    // ================= LATEST ORDER =================
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

    // ================= NOTIFIKASI PESANAN BARU =================
public function count_pesanan_baru()
    {
        return $this->db
            ->where('status_pesanan', 'dibuat')
            ->count_all_results('penjualan');
    }

    /**
     * LIST PESANAN BARU (UNTUK DROPDOWN NOTIF)
     */
    public function get_pesanan_baru($limit = 5)
    {
        return $this->db
            ->select('
                penjualan.id_penjualan,
                penjualan.tanggal_pesanan,
                penjualan.total_harga,
                customer.nama AS nama_customer
            ')
            ->from('penjualan')
            ->join('customer', 'customer.id_customer = penjualan.id_customer')
            ->where('penjualan.status_pesanan', 'dibuat')
            ->order_by('penjualan.tanggal_pesanan', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    

}
