<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model');
        $this->load->library(['pagination', 'user_agent']);
        $this->load->helper(['url', 'text']);
    }

    // ==================================================
    // LIST SUPPLIER + SEARCH + PAGINATION
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q', true);
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        // ==================================================
        // HITUNG TOTAL SUPPLIER
        // ==================================================
        $total = $this->Supplier_model->count_all($keyword);

        // ==================================================
        // KONFIGURASI PAGINATION
        // ==================================================
        $config['base_url']             = base_url('admin/supplier');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        // ==================================================
        // DATA KE VIEW
        // ==================================================
        $data['title']      = 'Supplier';
        $data['supplier']   = $this->Supplier_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;
        $data['content']    = 'admin/supplier/index';

        // ==================================================
        // RENDER VIA TEMPLATE
        // ==================================================
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM TAMBAH SUPPLIER
    // ==================================================
    public function create()
    {
        $data = $this->data;

        $data['title']   = 'Tambah Supplier';
        $data['content'] = 'admin/supplier/create';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM EDIT SUPPLIER
    // ==================================================
    public function edit($id)
    {
        $data = $this->data;

        $supplier = $this->Supplier_model->get_by_id($id);
        if (!$supplier) show_404();

        $data['title']    = 'Edit Supplier';
        $data['supplier'] = $supplier;
        $data['content']  = 'admin/supplier/edit';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // SIMPAN SUPPLIER BARU
    // ==================================================
    public function store()
    {
        $data = [
            'nama_supplier' => $this->input->post('nama_supplier', true),
            'kontak'        => $this->input->post('kontak', true),
            'alamat'        => $this->input->post('alamat', true),
            'status_aktif'  => $this->input->post('status_aktif')
        ];

        $this->Supplier_model->insert($data);
        redirect('admin/supplier');
    }

    // ==================================================
    // UPDATE SUPPLIER
    // ==================================================
    public function update($id)
    {
        $data = [
            'nama_supplier' => $this->input->post('nama_supplier', true),
            'kontak'        => $this->input->post('kontak', true),
            'alamat'        => $this->input->post('alamat', true)
        ];

        $this->Supplier_model->update($id, $data);
        redirect('admin/supplier');
    }

    // ==================================================
    // AKTIFKAN SUPPLIER
    // ==================================================
    public function aktif($id)
    {
        $this->Supplier_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    // ==================================================
    // NONAKTIFKAN SUPPLIER
    // ==================================================
    public function nonaktif($id)
    {
        $this->Supplier_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }
}
