<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pembelian_model extends CI_Model
{
    // ==================================================
    // LAPORAN PEMBELIAN SUPPLIER (GROUP BY SUPPLIER)
    // ==================================================
    public function laporan_pembelian_supplier($start = null, $end = null)
    {
        $this->db->from('pembelian_supplier ps');
        $this->db->join('supplier s', 's.id_supplier = ps.id_supplier');
        $this->db->join('detail_pembelian_supplier dps', 'dps.id_pembelian = ps.id_pembelian');

        $this->db->select('
            s.id_supplier,
            s.nama_supplier,
            COUNT(DISTINCT ps.id_pembelian) AS total_transaksi,
            SUM(dps.subtotal) AS total_pembelian,
            MAX(ps.tanggal_pembelian) AS tanggal_terakhir
        ');

        if (!empty($start) && !empty($end)) {
            $this->db->where('DATE(ps.tanggal_pembelian) >=', $start);
            $this->db->where('DATE(ps.tanggal_pembelian) <=', $end);
        }

        $this->db->group_by('s.id_supplier');
        $this->db->order_by('tanggal_terakhir', 'DESC');

        return $this->db->get()->result();
    }

    // ==================================================
    // DETAIL PEMBELIAN SUPPLIER (LEVEL PRODUK)
    // ==================================================
    public function detail_pembelian_supplier($id_supplier, $start = null, $end = null)
    {
        $this->db->from('pembelian_supplier ps');
        $this->db->join('detail_pembelian_supplier dps', 'dps.id_pembelian = ps.id_pembelian');
        $this->db->join('produk p', 'p.id_produk = dps.id_produk');

        $this->db->select('
            ps.tanggal_pembelian,
            p.nama_produk,
            dps.jumlah_beli,
            dps.harga_modal_satuan,
            dps.subtotal
        ');

        $this->db->where('ps.id_supplier', $id_supplier);

        $this->_filter_tanggal($start, $end);

        $this->db->order_by('ps.tanggal_pembelian', 'DESC');

        return $this->db->get()->result();
    }

    // ==================================================
    // FILTER TANGGAL (GLOBAL)
    // ==================================================
    private function _filter_tanggal($start, $end)
    {
        if (!empty($start) && !empty($end)) {
            $this->db->where('DATE(ps.tanggal_pembelian) >=', $start);
            $this->db->where('DATE(ps.tanggal_pembelian) <=', $end);
        }
        // jika kosong → ambil semua
    }
}
