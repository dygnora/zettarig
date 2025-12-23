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

        // Helper 'url' WAJIB ada untuk generate slug
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

        $total_rows = $this->Produk_model->count_all($keyword);

        // Config Pagination
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

        $data['title']      = 'Produk';
        $data['produk']     = $this->Produk_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;
        $data['content']    = 'admin/produk/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM TAMBAH
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
    // STORE (SIMPAN DATA)
    // ==================================================
    public function store()
    {
        $gambar = $this->_upload_gambar();
        $nama_produk = $this->input->post('nama_produk', true);
        
        // 1. GENERATE SLUG (Sesuai nama kolom DB: slug_produk)
        $slug = url_title($nama_produk, 'dash', true);

        $data = [
            'nama_produk'   => $nama_produk,
            'slug_produk'   => $slug,  // <--- FIXED: Sesuai DB Referensi.txt
            'id_kategori'   => $this->input->post('id_kategori'),
            'id_brand'      => $this->input->post('id_brand'),
            'deskripsi'     => $this->input->post('deskripsi'),
            'harga_modal'   => $this->input->post('harga_modal'),
            'harga_jual'    => $this->input->post('harga_jual'),
            'deskripsi'   => $this->input->post('deskripsi'),
            'stok'          => 0, 
            'status_aktif'  => $this->input->post('status_aktif'),
            'gambar_produk' => $gambar
            // 'berat_gram' DIHAPUS karena tidak ada di DB Referensi.txt
        ];

        if ($this->Produk_model->insert($data)) {
            $this->session->set_flashdata('success', 'Produk berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan produk');
        }
        
        redirect('admin/produk');
    }

    // ==================================================
    // EDIT
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
    // UPDATE
    // ==================================================
    public function update($id)
    {
        $produk = $this->Produk_model->get_by_id($id);
        if (!$produk) show_404();

        $gambar = $this->_upload_gambar();
        $nama_produk = $this->input->post('nama_produk', true);
        $slug = url_title($nama_produk, 'dash', true);

        // Ambil input status_aktif, jika kosong (tidak ada di form), gunakan status yang sudah ada di DB
        $status_form = $this->input->post('status_aktif');
        $status_final = ($status_form !== null) ? $status_form : $produk->status_aktif;

        $data = [
            'nama_produk'   => $nama_produk,
            'slug_produk'   => $slug,
            'id_kategori'   => $this->input->post('id_kategori'),
            'id_brand'      => $this->input->post('id_brand'),
            'deskripsi'     => $this->input->post('deskripsi'),
            'harga_modal'   => $this->input->post('harga_modal'),
            'harga_jual'    => $this->input->post('harga_jual'),
            'status_aktif'  => $status_final // <--- GUNAKAN VARIABEL INI
        ];

        if ($gambar) {
            if (!empty($produk->gambar_produk)) {
                @unlink(FCPATH.'assets/uploads/produk/'.$produk->gambar_produk);
            }
            $data['gambar_produk'] = $gambar;
        }

        $this->Produk_model->update($id, $data);
        $this->session->set_flashdata('success', 'Produk berhasil diperbarui');
        redirect('admin/produk');
    }

    // ==================================================
    // AKTIF / NONAKTIF
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
    // UPLOAD GAMBAR
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
            // Tampilkan error jika upload gagal tapi jangan stop proses
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return null;
        }

        return $this->upload->data('file_name');
    }
}