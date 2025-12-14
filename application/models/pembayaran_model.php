<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    /**
     * Ambil semua pembayaran transfer
     */
    public function get_all()
    {
        return $this->db
            ->select('
                pt.id_pembayaran,
                pt.jumlah_dibayar,
                pt.status_verifikasi,
                pt.tanggal_upload,
                c.nama AS nama_customer
            ')
            ->from('pembayaran_transfer pt')
            ->join('penjualan p', 'p.id_penjualan = pt.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->order_by('pt.tanggal_upload', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Ambil detail pembayaran
     */
    public function get_by_id($id)
    {
        return $this->db
            ->select('
                pt.*,
                c.nama AS nama_customer,
                c.email
            ')
            ->from('pembayaran_transfer pt')
            ->join('penjualan p', 'p.id_penjualan = pt.id_penjualan')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where('pt.id_pembayaran', $id)
            ->get()
            ->row();
    }

    /**
     * Verifikasi pembayaran
     */
    public function verifikasi($id, $status)
    {
        return $this->db
            ->where('id_pembayaran', $id)
            ->update('pembayaran_transfer', [
                'status_verifikasi'  => $status,
                'tanggal_verifikasi' => date('Y-m-d H:i:s')
            ]);
    }
}
