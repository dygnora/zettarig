<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        // Pastikan model ini sudah dibuat seperti langkah sebelumnya
        $this->load->model('Search_model'); 
    }

    public function index()
    {
        $keyword = $this->input->get('q', TRUE);

        // Jika keyword kosong, kembalikan ke dashboard
        if (empty($keyword)) {
            redirect('admin/dashboard');
        }

        $data['title']     = 'Hasil Pencarian: ' . htmlspecialchars($keyword);
        $data['keyword']   = $keyword;
        
        // Panggil 3 fungsi pencarian dari Model
        $data['hasil_produk']    = $this->Search_model->search_produk($keyword);
        $data['hasil_customer']  = $this->Search_model->search_customer($keyword);
        $data['hasil_penjualan'] = $this->Search_model->search_penjualan($keyword);

        // View tetap mengarah ke folder admin/search
        $data['content']   = 'admin/search/index';
        
        $this->load->view('admin/layout/template', $data);
    }
}