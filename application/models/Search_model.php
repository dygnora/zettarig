<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model
{
    // 1. CARI PRODUK
    public function search_produk($keyword)
    {
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->like('nama_produk', $keyword);
        $this->db->or_like('deskripsi', $keyword); // Ini sudah benar
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    // 2. CARI CUSTOMER
    public function search_customer($keyword)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->group_start(); // Tambahkan grouping agar query lebih aman
            $this->db->like('nama', $keyword);
            $this->db->or_like('email', $keyword);
            $this->db->or_like('no_hp', $keyword);
        $this->db->group_end();
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    // 3. CARI PENJUALAN (YANG PERLU DISINKRONKAN)
    public function search_penjualan($keyword)
    {
        // PERBAIKAN 1: Hapus 'as nama_customer'. Gunakan 'c.nama' saja agar di view bisa dipanggil $t->nama
        $this->db->select('p.*, c.nama'); 
        
        $this->db->from('penjualan p');
        
        // PERBAIKAN 2: Gunakan 'left' join agar jika customer dihapus, transaksi tetap muncul
        $this->db->join('customer c', 'c.id_customer = p.id_customer', 'left'); 
        
        $this->db->group_start(); 
            $this->db->like('p.id_penjualan', $keyword);
            $this->db->or_like('c.nama', $keyword);
        $this->db->group_end();
        
        $this->db->order_by('p.tanggal_pesanan', 'DESC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }
}