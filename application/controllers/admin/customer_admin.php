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

    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q');
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        $total = $this->Customer_model->count_all($keyword);

        $config['base_url']             = base_url('admin/customer');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        $data['title']      = 'Customer';
        $data['customer']   = $this->Customer_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/customer/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function create()
    {
        $data = $this->data;
        $data['title'] = 'Tambah Customer';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/customer/create', $data);
        $this->load->view('admin/layout/footer');
    }

    public function edit($id)
    {
        $data = $this->data;

        $data['customer'] = $this->Customer_model->get_by_id($id);
        if (!$data['customer']) show_404();

        $data['title'] = 'Edit Customer';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/customer/edit', $data);
        $this->load->view('admin/layout/footer');
    }

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

    public function aktif($id)
    {
        $this->Customer_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    public function nonaktif($id)
    {
        $this->Customer_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }
}
