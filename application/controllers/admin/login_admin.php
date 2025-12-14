<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Kalau admin sudah login, langsung ke dashboard
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        // Load database (kalau belum autoload)
        $this->load->database();
    }

    // =========================
    // FORM LOGIN
    // =========================
    public function index()
    {
        $this->load->view('admin/auth/login');
    }

    // =========================
    // PROSES LOGIN
    // =========================
    public function process()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        // Validasi sederhana
        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi');
            redirect('admin/login');
        }

        // Ambil data admin
        $admin = $this->db->get_where('admin', [
            'username'     => $username,
            'status_aktif' => 1
        ])->row();

        if (!$admin) {
            $this->session->set_flashdata('error', 'Akun tidak ditemukan atau tidak aktif');
            redirect('admin/login');
        }

        // Verifikasi password
        if (!password_verify($password, $admin->password_hash)) {
            $this->session->set_flashdata('error', 'Password salah');
            redirect('admin/login');
        }

        // Update last_login
        $this->db->where('id_admin', $admin->id_admin);
        $this->db->update('admin', [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        // Set session admin
        $this->session->set_userdata([
            'admin_logged_in' => true,
            'admin_id'        => $admin->id_admin,
            'admin_username'  => $admin->username,
            'admin_name'      => $admin->nama_lengkap
        ]);

        // Redirect ke dashboard
        redirect('admin/dashboard');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
