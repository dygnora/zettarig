<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Produk_model', 'Kategori_model']);
        $this->load->helper(['url', 'text']);
        $this->load->library('pagination');
    }

    // ==================================================
    // KATALOG PRODUK (FILTER + PAGINATION FIX)
    // ==================================================
    public function index()
    {
        // 1. Ambil Filter dari URL
        $filters = [
            'keyword'   => $this->input->get('q', true),
            'kategori'  => $this->input->get('kategori', true),
            'min_price' => $this->input->get('min_price', true),
            'max_price' => $this->input->get('max_price', true)
        ];

        // 2. Config Pagination
        $config['base_url']             = base_url('produk');
        $config['total_rows']           = $this->Produk_model->count_filtered($filters);
        $config['per_page']             = 9; // 9 Produk per halaman
        
        // Settings Query String
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = TRUE; // [PENTING] Agar filter tidak reset

        // Styling Pagination (Pixel Style)
        $config['full_tag_open']    = '<nav><ul class="pagination justify-content-center mt-5">';
        $config['full_tag_close']   = '</ul></nav>';
        
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';
        
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';
        
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link" style="background-color: var(--pixel-orange); border-color: var(--pixel-orange); color: #000;">';
        $config['cur_tag_close']    = '</span></li>';
        
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        
        $config['attributes']       = ['class' => 'page-link pixel-font', 'style' => 'background: #000; border-color: #333; color: #fff; margin: 0 2px; font-size: 0.7rem;'];

        $this->pagination->initialize($config);

        // 3. Ambil Data
        $page = (int) $this->input->get('page');
        $offset = ($page > 0) ? $page : 0; // Karena page_query_string return offset langsung, bukan nomor halaman

        $data['produk']        = $this->Produk_model->get_filtered($config['per_page'], $offset, $filters);
        $data['kategori_list'] = $this->Kategori_model->get_all_active(); // Pastikan model ini ada
        $data['pagination']    = $this->pagination->create_links();
        $data['filters']       = $filters; // Kirim balik ke view
        
        $data['title']   = 'Katalog Hardware | Zettarig';
        $data['content'] = 'web/produk/index';

        $this->load->view('web/layout/template', $data);
    }

    public function detail($slug = null)
    {
        if (!$slug) show_404();

        $produk = $this->Produk_model->get_active_by_slug($slug);
        if (!$produk) show_404();

        $data['title']   = $produk->nama_produk . ' | Zettarig';
        $data['produk']  = $produk;
        $data['content'] = 'web/produk/detail';

        $this->load->view('web/layout/template', $data);
    }
}