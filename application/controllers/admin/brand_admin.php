<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Brand_model');
        $this->load->library(['pagination', 'upload', 'user_agent']);
        $this->load->helper(['url', 'text']);
    }

    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q');
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        $total = $this->Brand_model->count_all($keyword);

        $config['base_url']             = base_url('admin/brand');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        $data['title']      = 'Brand Produk';
        $data['brand']      = $this->Brand_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/brand/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function create()
    {
        $data = $this->data;
        $data['title'] = 'Tambah Brand';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/brand/create', $data);
        $this->load->view('admin/layout/footer');
    }

    public function edit($id)
    {
        $data = $this->data;

        $data['brand'] = $this->Brand_model->get_by_id($id);
        if (!$data['brand']) show_404();

        $data['title'] = 'Edit Brand';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/brand/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function store()
    {
        $logo = !empty($_FILES['logo']['name']) ? $this->_upload_logo() : null;

        $data = [
            'nama_brand'   => $this->input->post('nama_brand', true),
            'deskripsi'    => $this->input->post('deskripsi', true),
            'status_aktif' => $this->input->post('status_aktif'),
            'logo'         => $logo
        ];

        $this->Brand_model->insert($data);
        redirect('admin/brand');
    }

    public function update($id)
    {
        $brand = $this->Brand_model->get_by_id($id);
        if (!$brand) show_404();

        $data = [
            'nama_brand' => $this->input->post('nama_brand', true),
            'deskripsi'  => $this->input->post('deskripsi', true)
        ];

        if (!empty($_FILES['logo']['name'])) {
            $logo = $this->_upload_logo();

            if ($brand->logo && file_exists(FCPATH.'assets/uploads/brand/'.$brand->logo)) {
                unlink(FCPATH.'assets/uploads/brand/'.$brand->logo);
            }

            $data['logo'] = $logo;
        }

        $this->Brand_model->update($id, $data);
        redirect('admin/brand');
    }

    public function aktif($id)
    {
        $this->Brand_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    public function nonaktif($id)
    {
        $this->Brand_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }

    private function _upload_logo()
    {
        $path = FCPATH.'assets/uploads/brand/';
        if (!is_dir($path)) mkdir($path, 0755, true);

        $config = [
            'upload_path'   => $path,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 1024,
            'encrypt_name'  => true
        ];

        $this->upload->initialize($config, true);

        if (!$this->upload->do_upload('logo')) {
            show_error($this->upload->display_errors('', ''));
        }

        return $this->upload->data('file_name');
    }
}
