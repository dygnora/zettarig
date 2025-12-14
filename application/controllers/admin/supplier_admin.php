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

    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q');
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        $total = $this->Supplier_model->count_all($keyword);

        $config['base_url']             = base_url('admin/supplier');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        $data['title']      = 'Supplier';
        $data['supplier']   = $this->Supplier_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/supplier/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function create()
    {
        $data = $this->data;
        $data['title'] = 'Tambah Supplier';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/supplier/create', $data);
        $this->load->view('admin/layout/footer');
    }

    public function edit($id)
    {
        $data = $this->data;

        $data['supplier'] = $this->Supplier_model->get_by_id($id);
        if (!$data['supplier']) show_404();

        $data['title'] = 'Edit Supplier';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/supplier/edit', $data);
        $this->load->view('admin/layout/footer');
    }

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

    public function aktif($id)
    {
        $this->Supplier_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    public function nonaktif($id)
    {
        $this->Supplier_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }
}
