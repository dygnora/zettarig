<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->library(['pagination', 'user_agent']);
        $this->load->helper(['url', 'text']);
    }

    // ==================================================
    // LIST CUSTOMER + SEARCH + PAGINATION
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q', true);
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        // ==================================================
        // HITUNG TOTAL CUSTOMER
        // ==================================================
        $total = $this->Customer_model->count_all($keyword);

        // ==================================================
        // KONFIGURASI PAGINATION
        // ==================================================
        $config['base_url']             = base_url('admin/customer');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        // ==================================================
        // DATA KE VIEW
        // ==================================================
        $data['title']      = 'Customer';
        $data['customer']   = $this->Customer_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;
        $data['content']    = 'admin/customer/index';

        // ==================================================
        // RENDER VIA TEMPLATE
        // ==================================================
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM TAMBAH CUSTOMER
    // ==================================================
    public function create()
    {
        $data = $this->data;

        $data['title']   = 'Tambah Customer';
        $data['content'] = 'admin/customer/create';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM EDIT CUSTOMER
    // ==================================================
    public function edit($id)
    {
        $data = $this->data;

        $customer = $this->Customer_model->get_by_id($id);
        if (!$customer) show_404();

        $data['title']    = 'Edit Customer';
        $data['customer'] = $customer;
        $data['content']  = 'admin/customer/edit';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // SIMPAN CUSTOMER BARU
    // ==================================================
    public function store()
    {
        $data = [
            'nama'          => $this->input->post('nama', true),
            'username'      => $this->input->post('username', true),
            'email'         => $this->input->post('email', true),
            'no_hp'         => $this->input->post('no_hp', true),
            'alamat'        => $this->input->post('alamat', true),
            'password_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'status_aktif'  => $this->input->post('status_aktif')
        ];

        $this->Customer_model->insert($data);
        redirect('admin/customer');
    }

    // ==================================================
    // UPDATE CUSTOMER
    // ==================================================
    public function update($id)
    {
        $data = [
            'nama'   => $this->input->post('nama', true),
            'email'  => $this->input->post('email', true),
            'no_hp'  => $this->input->post('no_hp', true),
            'alamat' => $this->input->post('alamat', true)
        ];

        if ($this->input->post('password')) {
            $data['password_hash'] = password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->Customer_model->update($id, $data);
        redirect('admin/customer');
    }

    // ==================================================
    // AKTIFKAN CUSTOMER
    // ==================================================
    public function aktif($id)
    {
        $this->Customer_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    // ==================================================
    // NONAKTIFKAN CUSTOMER
    // ==================================================
    public function nonaktif($id)
    {
        $this->Customer_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }
}
