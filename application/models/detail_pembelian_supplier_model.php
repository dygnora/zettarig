<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_pembelian_supplier_model extends CI_Model
{
    protected $table = 'detail_pembelian_supplier';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_pembelian($id_pembelian)
    {
        return $this->db
            ->select('detail_pembelian_supplier.*, produk.nama_produk')
            ->from($this->table)
            ->join('produk', 'produk.id_produk = detail_pembelian_supplier.id_produk')
            ->where('id_pembelian', $id_pembelian)
            ->get()
            ->result();
    }
}
