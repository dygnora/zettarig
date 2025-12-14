<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    /**
     * LAPORAN PENJUALAN
     * GROUP BY CUSTOMER
     */
    public function laporan_penjualan_group_user($mode, $start, $end)
    {
        $this->_filter_waktu($mode, $start, $end);

        return $this->db
            ->select('
                c.id_customer,
                c.nama AS nama_customer,
                COUNT(p.id_penjualan) AS total_transaksi,
                SUM(p.total_harga) AS total_belanja
            ')
            ->from('penjualan p')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->group_by('c.id_customer')
            ->order_by('total_belanja', 'DESC')
            ->get()
            ->result();
    }

    /**
     * DETAIL TRANSAKSI PER CUSTOMER
     */
    public function detail_penjualan_user($id_customer, $mode, $start, $end)
    {
        $this->_filter_waktu($mode, $start, $end);

        return $this->db
            ->select('
                p.id_penjualan,
                p.tanggal_pesanan,
                p.total_harga,
                p.metode_pembayaran,
                p.status_pesanan
            ')
            ->from('penjualan p')
            ->where('p.id_customer', $id_customer)
            ->order_by('p.tanggal_pesanan', 'DESC')
            ->get()
            ->result();
    }

    /**
     * DATA CUSTOMER
     */
    public function get_customer($id_customer)
    {
        return $this->db
            ->where('id_customer', $id_customer)
            ->get('customer')
            ->row();
    }

    /**
     * FILTER WAKTU
     * harian | mingguan | bulanan
     */
    private function _filter_waktu($mode, $start, $end)
    {
        if ($start && $end) {
            $this->db->where('DATE(p.tanggal_pesanan) >=', $start);
            $this->db->where('DATE(p.tanggal_pesanan) <=', $end);
            return;
        }

        switch ($mode) {
            case 'mingguan':
                $this->db->where('YEARWEEK(p.tanggal_pesanan)', date('oW'));
                break;

            case 'bulanan':
                $this->db->where('MONTH(p.tanggal_pesanan)', date('m'));
                $this->db->where('YEAR(p.tanggal_pesanan)', date('Y'));
                break;

            default: // harian
                $this->db->where('DATE(p.tanggal_pesanan)', date('Y-m-d'));
                break;
        }
    }
}
