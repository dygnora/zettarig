<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    // ==================================================
    // LAPORAN PENJUALAN (GROUP BY CUSTOMER)
    // ==================================================
    public function laporan_penjualan_group_user($mode, $start, $end)
    {
        $this->db->from('penjualan p');
        $this->db->join('customer c', 'c.id_customer = p.id_customer');

        $this->db->select('
            c.id_customer,
            c.nama AS nama_customer,
            COUNT(DISTINCT p.id_penjualan) AS total_transaksi,
            SUM(p.total_harga) AS total_belanja,
            MAX(p.tanggal_pesanan) AS tanggal_transaksi
        ');

        $this->_filter_waktu($mode, $start, $end);

        $this->db->group_by('c.id_customer');
        $this->db->order_by('tanggal_transaksi', 'DESC');

        return $this->db->get()->result();
    }

    // ==================================================
    // DETAIL PENJUALAN PER CUSTOMER (DENGAN PRODUK)
    // ==================================================
    public function detail_penjualan_user($id_customer, $mode, $start, $end)
    {
        $this->db->from('penjualan p');
        $this->db->join('detail_penjualan dp', 'dp.id_penjualan = p.id_penjualan');
        $this->db->join('produk pr', 'pr.id_produk = dp.id_produk');

        $this->db->where('p.id_customer', $id_customer);

        $this->db->select('
            p.id_penjualan,
            p.tanggal_pesanan,
            p.metode_pembayaran,
            p.status_pesanan,
            pr.nama_produk,
            dp.jumlah,
            dp.subtotal
        ');

        $this->_filter_waktu($mode, $start, $end);

        $this->db->order_by('p.tanggal_pesanan', 'DESC');
        $this->db->order_by('p.id_penjualan', 'DESC');

        return $this->db->get()->result();
    }

    // ==================================================
    // GET DATA CUSTOMER
    // ==================================================
    public function get_customer($id_customer)
    {
        return $this->db
            ->where('id_customer', $id_customer)
            ->get('customer')
            ->row();
    }

    // ==================================================
    // FILTER WAKTU (DIGUNAKAN GLOBAL)
    // ==================================================
    private function _filter_waktu($mode, $start, $end)
    {
        // ==============================
        // RANGE TANGGAL (PRIORITAS)
        // ==============================
        if (!empty($start) && !empty($end)) {
            $this->db->where('DATE(p.tanggal_pesanan) >=', $start);
            $this->db->where('DATE(p.tanggal_pesanan) <=', $end);
            return;
        }

        // ==============================
        // MODE BULANAN (BULAN & TAHUN SAAT INI)
        // ==============================
        if ($mode === 'bulanan') {
            $this->db->where('MONTH(p.tanggal_pesanan)', date('m'));
            $this->db->where('YEAR(p.tanggal_pesanan)', date('Y'));
        }

        // ==============================
        // MODE HARlAN TIDAK DIPAKSA
        // (jika tidak ada filter, ambil semua data)
        // ==============================
    }
}
