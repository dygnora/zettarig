<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Model & Helper yang dibutuhkan
        $this->load->model('Penjualan_model'); // Pastikan model ini ada
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');

        // Cek Login Global untuk controller ini
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            exit;
        }
    }

    // ==================================================
    // DASHBOARD AKUN (INDEX)
    // ==================================================
    public function index()
    {
        $id_customer = $this->session->userdata('customer_id');

        // [FIX UTAMA] Ambil data FRESH dari database, jangan dari session.
        // Agar jika foto baru saja diupload, langsung terlihat perubahannya.
        $customer = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();

        // Jika user tidak ditemukan (misal dihapus admin saat login), logout paksa
        if (!$customer) {
            $this->logout(); 
            return;
        }

        $data['title']    = 'Dashboard Player | Zettarig';
        $data['customer'] = $customer; // Kirim data terbaru ke view
        $data['content']  = 'web/akun/index';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // EDIT PROFIL & UPLOAD FOTO (GABUNGAN)
    // ==================================================
    public function edit()
{
    // 1. Cek Login
    if (!$this->session->userdata('customer_logged_in')) {
        redirect('auth/login');
    }

    $id_customer = $this->session->userdata('customer_id');

    $this->load->library('form_validation');
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
    $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim|numeric');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

    if ($this->form_validation->run() == false) {
        $data['title']    = 'Edit Character | Zettarig';
        // Ambil data terbaru dari DB
        $data['customer'] = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();
        $data['content']  = 'web/akun/edit'; 
        $this->load->view('web/layout/template', $data);

    } else {
        
        $update_data = [
            'nama'   => $this->input->post('nama', true),
            'no_hp'  => $this->input->post('no_hp', true),
            'alamat' => $this->input->post('alamat', true),
        ];

        // 2. CEK UPLOAD FOTO (LOGIC DIPERBAIKI)
        // Pastikan user benar-benar memilih file
        if (!empty($_FILES['foto_profil']['name'])) {
            
            // GUNAKAN FCPATH (Path Absolut) agar tidak salah folder
            $config['upload_path']   = FCPATH . 'assets/uploads/profil/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 5048; // Naikkan ke 5MB biar aman
            // Tambahkan uniqid agar nama file SELALU BARU (mengatasi cache)
            $config['file_name']     = 'profile-' . $id_customer . '-' . uniqid();
            $config['overwrite']     = true;

            // Buat folder jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_profil')) {
                // Upload Sukses
                $img_data = $this->upload->data();
                $update_data['foto_profil'] = $img_data['file_name'];
                
                // Update Session Foto (PENTING AGAR NAVBAR BERUBAH)
                $this->session->set_userdata('customer_foto', $img_data['file_name']);
            } else {
                // Upload Gagal -> Tampilkan Error
                $this->session->set_flashdata('error', 'Gagal Upload: ' . $this->upload->display_errors('', ''));
                redirect('akun/edit');
                return; 
            }
        }

        // 3. Cek Password
        $password_baru = $this->input->post('password');
        if (!empty($password_baru)) {
            $update_data['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        // 4. Update Database
        $this->db->where('id_customer', $id_customer);
        $this->db->update('customer', $update_data);

        $this->session->set_userdata('customer_nama', $update_data['nama']);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        redirect('akun');
    }
}

    // ==================================================
    // UPLOAD FOTO (Shortcut dari Dashboard Index)
    // ==================================================
    public function upload_foto()
    {
        $id_customer = $this->session->userdata('customer_id');

        $config['upload_path']   = './assets/uploads/profil/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = 'profile-' . $id_customer . '-' . time();

        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_profil')) {
            $file_name = $this->upload->data('file_name');

            // Update DB
            $this->db->where('id_customer', $id_customer);
            $this->db->update('customer', ['foto_profil' => $file_name]);
            
            // Update Session
            $this->session->set_userdata('customer_foto', $file_name);
            
            $this->session->set_flashdata('success', 'Avatar berhasil diganti!');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }
        
        redirect('akun');
    }

    // ==================================================
    // RIWAYAT PESANAN
    // ==================================================
    public function pesanan()
    {
        $data['title']   = 'Riwayat Pesanan | Zettarig';
        $data['pesanan'] = $this->Penjualan_model->get_by_customer($this->session->userdata('customer_id'));
        $data['content'] = 'web/akun/pesanan';
        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // DETAIL PESANAN
    // ==================================================
    public function pesanan_detail($id_penjualan)
    {
        $id_customer = $this->session->userdata('customer_id');

        // Header Pesanan
        $pesanan = $this->db->get_where('penjualan', [
            'id_penjualan' => $id_penjualan, 
            'id_customer'  => $id_customer
        ])->row();

        if (!$pesanan) { show_404(); return; }

        // Detail Item
        $detail = $this->db->select('dp.*, p.nama_produk, p.gambar_produk')
            ->from('detail_penjualan dp')
            ->join('produk p', 'p.id_produk = dp.id_produk')
            ->where('dp.id_penjualan', $id_penjualan)
            ->get()->result();

        // Data COD
        $cod = ($pesanan->metode_pembayaran == 'cod') 
            ? $this->db->get_where('pembayaran_cod', ['id_penjualan' => $id_penjualan])->row() 
            : null;

        // Timeline
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
    // LOGOUT
    // ==================================================
    public function logout()
    {
        $this->session->unset_userdata(['customer_logged_in', 'customer_id', 'customer_nama', 'customer_email', 'customer_foto']);
        redirect('auth/login');
    }
}