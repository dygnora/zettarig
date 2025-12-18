<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // ===============================
        // LOAD MODEL & HELPER
        // ===============================
        $this->load->model('Produk_model');
        $this->load->helper(['url', 'text']);
    }

    // ==================================================
    // KATALOG PRODUK
    // URL : /produk
    // ==================================================
    public function index()
    {
        $data = [];

        // ===============================
        // PARAMETER QUERY STRING
        // ===============================
        $keyword     = $this->input->get('q', true);
        $kategori_id = $this->input->get('kategori', true);
        $page        = (int) $this->input->get('page');
        $limit       = 10;
        $offset      = ($page > 0) ? ($page - 1) * $limit : 0;

        // ===============================
        // LOAD MODEL TAMBAHAN
        // ===============================
        $this->load->model('Kategori_model');

        // ===============================
        // TOTAL DATA (UNTUK PAGINATION)
        // ===============================
        $total = $this->Produk_model->count_active_products($keyword, $kategori_id);

        // ===============================
        // PAGINATION CONFIG (BOOTSTRAP)
        // ===============================
        $this->load->library('pagination');

        $config['base_url']            = base_url('produk');
        $config['total_rows']          = $total;
        $config['per_page']            = $limit;
        $config['page_query_string']   = true;
        $config['query_string_segment']= 'page';
        $config['reuse_query_string']  = true;

        $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']  = '</span></li>';
        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // ===============================
        // DATA KE VIEW
        // ===============================
        $data['title']       = 'Produk | Zettarig';
        $data['produk']      = $this->Produk_model
            ->get_active_products_paginated($limit, $offset, $keyword, $kategori_id);
        $data['kategori']    = $this->Kategori_model->get_all_active();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']     = $keyword;
        $data['kategori_id']= $kategori_id;
        $data['content']    = 'web/produk/index';

        $this->load->view('web/layout/template', $data);
    }


    // ==================================================
    // DETAIL PRODUK (BERDASARKAN SLUG)
    // URL : /produk/{slug}
    // ==================================================
    public function detail($slug = null)
    {
        if (!$slug) {
            show_404();
        }

        // ===============================
        // AMBIL PRODUK BERDASARKAN SLUG
        // ===============================
        $produk = $this->Produk_model->get_active_by_slug($slug);

        if (!$produk) {
            show_404();
        }

        $data = [];

        // ===============================
        // DATA PAGE
        // ===============================
        $data['title']  = $produk->nama_produk . ' | Zettarig';
        $data['produk'] = $produk;

        // ===============================
        // VIEW
        // ===============================
        $data['content'] = 'web/produk/detail';

        $this->load->view('web/layout/template', $data);
    }
}
