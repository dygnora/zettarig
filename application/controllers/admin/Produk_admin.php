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
            'Brand_model'
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
        $offset  = max((int) $this->input->get('page'), 0);
        $limit   = 10;

        // ==================================================
        // HITUNG TOTAL PRODUK
        // ==================================================
        $total_rows = $this->Produk_model->count_all($keyword);

        // ==================================================
        // KONFIGURASI PAGINATION (ADMINLTE STYLE)
        // ==================================================
        $config['base_url']             = base_url('admin/produk');
        $config['total_rows']           = $total_rows;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = true;

        $config['full_tag_open']  = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';

        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';

        $config['cur_tag_open']   = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']  = '</a></li>';

        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // ==================================================
        // DATA KE VIEW
        // ==================================================
        $data['title']      = 'Produk';
        $data['produk']     = $this->Produk_model
                                    ->get_paginated($limit, $offset, $keyword);
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
        $data['content']  = 'admin/produk/create';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // SIMPAN PRODUK BARU
    // ==================================================
    public function store()
    {
        $gambar = $this->_upload_gambar();

        $data = [
            'nama_produk'   => $this->input->post('nama_produk', true),
            'id_kategori'   => $this->input->post('id_kategori'),
            'id_brand'      => $this->input->post('id_brand'),
            'harga_jual'    => $this->input->post('harga_jual'),
            'stok'          => 0, // stok dari pembelian supplier
            'status_aktif'  => $this->input->post('status_aktif'),
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

        $gambar = $this->_upload_gambar();

        $data = [
            'nama_produk'  => $this->input->post('nama_produk', true),
            'id_kategori'  => $this->input->post('id_kategori'),
            'id_brand'     => $this->input->post('id_brand'),
            'harga_jual'   => $this->input->post('harga_jual'),
            'status_aktif' => $this->input->post('status_aktif')
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
    // AKTIF / NONAKTIF PRODUK
    // ==================================================
    public function aktif($id)
    {
        $this->Produk_model->set_status($id, 1);
        redirect($this->agent->referrer() ?: 'admin/produk');
    }

    public function nonaktif($id)
    {
        $this->Produk_model->set_status($id, 0);
        redirect($this->agent->referrer() ?: 'admin/produk');
    }

    // ==================================================
    // UPLOAD GAMBAR PRODUK
    // ==================================================
    private function _upload_gambar()
    {
        if (empty($_FILES['gambar']['name'])) {
            return null;
        }

        $path = FCPATH.'assets/uploads/produk/';
        if (!is_dir($path)) mkdir($path, 0755, true);

        $config = [
            'upload_path'   => $path,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => true
        ];

        $this->upload->initialize($config, true);

        if (!$this->upload->do_upload('gambar')) {
            show_error($this->upload->display_errors('', ''));
        }

        return $this->upload->data('file_name');
    }
}
