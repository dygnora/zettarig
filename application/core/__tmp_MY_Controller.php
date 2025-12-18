<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $is_admin = false;
    protected $data = []; // ⬅️ WAJIB

    public function __construct()
    {
        parent::__construct();

        // proteksi halaman admin
        if ($this->is_admin) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect('admin/auth/login');
                exit;
            }
        }

        // data global navbar (notifikasi)
        if ($this->session->userdata('admin_logged_in')) {
            $this->load->model('Dashboard_model');

            $this->data['notif_count'] = $this->Dashboard_model->count_pesanan_baru();
            $this->data['notif_items'] = $this->Dashboard_model->get_pesanan_baru();
        }
    }
}
