<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            'Produk_model',
            'Kategori_model',
            'Brand_model',
            'Supplier_model'
        ]);

        $this->load->library(['pagination', 'user_agent', 'upload']);
        $this->load->helper(['url', 'text']);
    }

    // ==================================================
    // LIST PRODUK + SEARCH + PAGINATION
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q', true);
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        // ==================================================
        // HITUNG TOTAL PRODUK
        // ==================================================
        $total = $this->Produk_model->count_all($keyword);

        // ==================================================
        // KONFIGURASI PAGINATION
        // ==================================================
        $config['base_url']             = base_url('admin/produk');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        // ==================================================
        // DATA KE VIEW
        // ==================================================
        $data['title']      = 'Produk';
        $data['produk']     = $this->Produk_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;
        $data['content']    = 'admin/produk/index';

        // ==================================================
        // RENDER VIA TEMPLATE
        // ==================================================
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM TAMBAH PRODUK
    // ==================================================
    public function create()
    {
        $data = $this->data;

        $data['title']    = 'Tambah Produk';
        $data['kategori'] = $this->Kategori_model->get_all_active();
        $data['brand']    = $this->Brand_model->get_all_active();
        $data['supplier'] = $this->Supplier_model->get_all_active();
        $data['content']  = 'admin/produk/create';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // SIMPAN PRODUK BARU
    // ==================================================
    public function store()
    {
        $gambar = $this->upload_gambar();

        $data = [
            'nama_produk'   => $this->input->post('nama_produk', true),
            'id_kategori'   => $this->input->post('id_kategori'),
            'id_brand'      => $this->input->post('id_brand'),
            'id_supplier'   => $this->input->post('id_supplier'),
            'harga_jual'    => $this->input->post('harga_jual'),
            'stok'          => (int) $this->input->post('stok'),
            'status_aktif'  => 1,
            'gambar_produk' => $gambar
        ];

        $this->Produk_model->insert($data);
        redirect('admin/produk');
    }

    // ==================================================
    // FORM EDIT PRODUK
    // ==================================================
    public function edit($id)
    {
        $data = $this->data;

        $produk = $this->Produk_model->get_by_id($id);
        if (!$produk) show_404();

        $data['title']    = 'Edit Produk';
        $data['produk']   = $produk;
        $data['kategori'] = $this->Kategori_model->get_all_active();
        $data['brand']    = $this->Brand_model->get_all_active();
        $data['supplier'] = $this->Supplier_model->get_all_active();
        $data['content']  = 'admin/produk/edit';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // UPDATE PRODUK
    // ==================================================
    public function update($id)
    {
        $produk = $this->Produk_model->get_by_id($id);
        if (!$produk) show_404();

        $gambar = $this->upload_gambar();

        $data = [
            'nama_produk' => $this->input->post('nama_produk', true),
            'id_kategori' => $this->input->post('id_kategori'),
            'id_brand'    => $this->input->post('id_brand'),
            'id_supplier' => $this->input->post('id_supplier'),
            'harga_jual'  => $this->input->post('harga_jual'),
            'stok'        => (int) $this->input->post('stok')
        ];

        if ($gambar) {
            if (!empty($produk->gambar_produk)) {
                @unlink(FCPATH.'assets/uploads/produk/'.$produk->gambar_produk);
            }
            $data['gambar_produk'] = $gambar;
        }

        $this->Produk_model->update($id, $data);
        redirect('admin/produk');
    }

    // ==================================================
    // AKTIFKAN / NONAKTIFKAN PRODUK
    // ==================================================
    public function aktif($id)
    {
        $this->Produk_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    public function nonaktif($id)
    {
        $this->Produk_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }

    // ==================================================
    // UPLOAD GAMBAR PRODUK (PRIVATE)
    // ==================================================
    private function upload_gambar()
    {
        if (empty($_FILES['gambar']['name'])) {
            return null;
        }

        $config['upload_path']   = FCPATH.'assets/uploads/produk/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('gambar_produk')) {
            $this->session->set_flashdata(
                'error',
                $this->upload->display_errors('', '')
            );
            redirect($this->agent->referrer());
            exit;
        }

        return $this->upload->data('file_name');
    }
}
