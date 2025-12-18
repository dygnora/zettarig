<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_pembelian_supplier_model extends CI_Model
{
    protected $table = 'detail_pembelian_supplier';

    // ==================================================
    // INSERT DETAIL PEMBELIAN
    // ==================================================
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ==================================================
    // AMBIL DETAIL PEMBELIAN + DATA PRODUK (NAMA + GAMBAR)
    // ==================================================
    public function get_by_pembelian($id_pembelian)
    {
        return $this->db
            ->select('
                d.*,
                p.nama_produk,
                p.gambar_produk
            ')
            ->from($this->table . ' d')
            ->join('produk p', 'p.id_produk = d.id_produk')
            ->where('d.id_pembelian', $id_pembelian)
            ->get()
            ->result();
    }
}
