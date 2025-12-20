<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model
{
    // 1. CARI PRODUK (Nama atau Deskripsi)
    public function search_produk($keyword)
    {
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->like('nama_produk', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->limit(5); // Batasi hasil agar tidak kepanjangan
        return $this->db->get()->result();
    }

    // 2. CARI CUSTOMER (Nama, Email, atau No HP)
    public function search_customer($keyword)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->like('nama', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('no_hp', $keyword);
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    // 3. CARI PENJUALAN (ID Penjualan atau Nama Customer)
    public function search_penjualan($keyword)
    {
        $this->db->select('p.*, c.nama as nama_customer');
        $this->db->from('penjualan p');
        $this->db->join('customer c', 'c.id_customer = p.id_customer');
        
        // Group start/end penting agar logic OR tidak berantakan dengan JOIN
        $this->db->group_start(); 
            $this->db->like('p.id_penjualan', $keyword); // Cari ID Transaksi
            $this->db->or_like('c.nama', $keyword);      // Cari Nama Pembeli
        $this->db->group_end();
        
        $this->db->order_by('p.tanggal_pesanan', 'DESC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }
}