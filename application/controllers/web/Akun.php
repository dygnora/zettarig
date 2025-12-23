<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model'); 
        $this->load->library(['session', 'form_validation', 'upload', 'pagination']); // Load Pagination
        $this->load->helper(['url', 'form']);

        // Cek Login Global
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            exit;
        }
    }

    // ==================================================
    // 1. DASHBOARD AKUN
    // ==================================================
    public function index()
    {
        $id_customer = $this->session->userdata('customer_id');
        $customer = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();

        if (!$customer) {
            $this->logout(); 
            return;
        }

        $data['title']    = 'Dashboard Player | Zettarig';
        $data['customer'] = $customer; 
        $data['content']  = 'web/akun/index';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // 2. EDIT PROFIL
    // ==================================================
    public function edit()
    {
        $id_customer = $this->session->userdata('customer_id');

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $data['title']    = 'Edit Character | Zettarig';
            $data['customer'] = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();
            $data['content']  = 'web/akun/edit'; 
            
            if(validation_errors()){
                $this->session->set_flashdata('error', 'Cek kembali isian Anda: ' . validation_errors());
            }
            $this->load->view('web/layout/template', $data);

        } else {
            $update_data = [
                'nama'   => $this->input->post('nama', true),
                'no_hp'  => $this->input->post('no_hp', true),
                'alamat' => $this->input->post('alamat', true),
            ];

            $password_baru = $this->input->post('password');
            if (!empty($password_baru)) {
                $update_data['password_hash'] = password_hash($password_baru, PASSWORD_DEFAULT);
            }

            $this->db->where('id_customer', $id_customer);
            $this->db->update('customer', $update_data);

            $this->session->set_userdata('customer_nama', $update_data['nama']);
            $this->session->set_flashdata('success', 'Data karakter berhasil diperbarui!');
            redirect('akun');
        }
    }

    // ==================================================
    // 3. UPLOAD FOTO
    // ==================================================
    public function upload_foto()
    {
        $id_customer = $this->session->userdata('customer_id');

        $config['upload_path']   = FCPATH . 'assets/uploads/profil/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 5120;
        $config['file_name']     = 'avatar_' . $id_customer . '_' . time();
        $config['overwrite']     = true;

        if (!is_dir($config['upload_path'])) { mkdir($config['upload_path'], 0777, true); }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_profil')) {
            $old = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();
            if ($old && !empty($old->foto_profil)) {
                $path = FCPATH . 'assets/uploads/profil/' . $old->foto_profil;
                if (file_exists($path)) unlink($path);
            }

            $file_name = $this->upload->data('file_name');
            $this->db->where('id_customer', $id_customer);
            $this->db->update('customer', ['foto_profil' => $file_name]);
            
            $this->session->set_userdata('customer_foto', $file_name);
            $this->session->set_flashdata('success', 'Avatar berhasil diganti!');
        } else {
            $this->session->set_flashdata('error', 'Gagal Upload: ' . $this->upload->display_errors());
        }
        
        redirect('akun');
    }

    // ==================================================
    // 4. RIWAYAT PESANAN (DENGAN PAGINATION)
    // ==================================================
    public function pesanan()
    {
        $id_customer = $this->session->userdata('customer_id');

        // 1. Konfigurasi Pagination
        $config['base_url']   = base_url('akun/pesanan');
        $config['total_rows'] = $this->Penjualan_model->count_by_customer($id_customer);
        $config['per_page']   = 10; // Tampilkan 10 data per halaman
        
        // Styling Pagination (Bootstrap/Pixel Style)
        $config['full_tag_open']   = '<nav class="mt-4"><ul class="pagination justify-content-center">';
        $config['full_tag_close']  = '</ul></nav>';
        
        $config['first_link']      = '<<';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link']       = '>>';
        $config['last_tag_open']   = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';
        
        $config['next_link']       = 'NEXT >';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        
        $config['prev_link']       = '< PREV';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        
        $config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']   = '</a></li>';
        
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        
        $config['attributes']      = array('class' => 'page-link pixel-font'); // Custom class

        $this->pagination->initialize($config);

        // 2. Ambil Data Sesuai Halaman
        $start = $this->uri->segment(3); // Mengambil offset dari URL
        $data['pesanan'] = $this->Penjualan_model->get_paged_by_customer($id_customer, $config['per_page'], $start);
        
        $data['pagination'] = $this->pagination->create_links();
        $data['title']      = 'Riwayat Misi | Zettarig';
        $data['content']    = 'web/akun/pesanan';
        
        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // 5. DETAIL PESANAN
    // ==================================================
    public function pesanan_detail($id_penjualan)
    {
        $id_customer = $this->session->userdata('customer_id');

        $pesanan = $this->db->get_where('penjualan', [
            'id_penjualan' => $id_penjualan, 
            'id_customer'  => $id_customer
        ])->row();

        if (!$pesanan) { show_404(); return; }

        $detail = $this->db->select('dp.*, p.nama_produk, p.gambar_produk')
            ->from('detail_penjualan dp')
            ->join('produk p', 'p.id_produk = dp.id_produk')
            ->where('dp.id_penjualan', $id_penjualan)
            ->get()->result();

        $cod = ($pesanan->metode_pembayaran == 'cod') 
            ? $this->db->get_where('pembayaran_cod', ['id_penjualan' => $id_penjualan])->row() 
            : null;

        $timeline = $this->db->order_by('waktu', 'ASC')
            ->get_where('timeline_pesanan', ['id_penjualan' => $id_penjualan])
            ->result();

        $data['title']    = 'Detail Pesanan #' . $id_penjualan;
        $data['pesanan']  = $pesanan;
        $data['detail']   = $detail;
        $data['cod']      = $cod;
        $data['timeline'] = $timeline;
        $data['content']  = 'web/akun/pesanan_detail';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // 6. LOGOUT
    // ==================================================
    public function logout()
    {
        $this->session->unset_userdata(['customer_logged_in', 'customer_id', 'customer_nama', 'customer_email', 'customer_foto']);
        redirect('auth/login');
    }
}