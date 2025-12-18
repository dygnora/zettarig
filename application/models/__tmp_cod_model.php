<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cod_model extends CI_Model
{
    /**
     * Ambil semua data COD
     */
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

    /**
     * Ambil detail COD
     */
    public function get_by_id($id)
    {
        return $this->db
            ->select('
                pc.*,
                p.total_harga,
                c.nama AS nama_customer
            ')
            ->from('pembayaran_cod pc')
            ->join('penjualan p', 'p.id_penjualan = pc.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where('pc.id_cod', $id)
            ->get()
            ->row();
    }

    /**
     * Verifikasi DP (diterima / ditolak)
     */
    public function verifikasi_dp($id, $status)
    {
        return $this->db
            ->where('id_cod', $id)
            ->update('pembayaran_cod', [
                'status_dp' => $status
            ]);
    }

    /**
     * Tandai pelunasan COD
     */
    public function pelunasan($id)
    {
        return $this->db
            ->where('id_cod', $id)
            ->update('pembayaran_cod', [
                'status_pelunasan' => 'lunas'
            ]);
    }
}
