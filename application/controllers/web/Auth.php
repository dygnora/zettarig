<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper(['url', 'security']);
    }

    // ==================================================
    // LOGIN PAGE
    // ==================================================
    public function login()
    {
        if ($this->session->userdata('customer_logged_in')) {
            redirect('akun');
            return;
        }

        $data['title']   = 'Login | Zettarig';
        $data['content'] = 'web/auth/login';
        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // PROSES LOGIN
    // ==================================================
    public function process_login()
    {
        $email    = $this->security->xss_clean($this->input->post('email'));
        $password = $this->input->post('password');

        if (!$email || !$password) {
            $this->session->set_flashdata('error', 'Email dan password wajib diisi.');
            redirect('auth/login');
            return;
        }

        $customer = $this->db
            ->where('email', $email)
            ->where('status_aktif', 1)
            ->limit(1)
            ->get('customer')
            ->row();

        if (!$customer || !password_verify($password, $customer->password_hash)) {
            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('auth/login');
            return;
        }

        // ===============================
        // SET SESSION LOGIN
        // ===============================
        $this->session->set_userdata([
            'customer_logged_in' => true,
            'customer_id'        => $customer->id_customer,
            'customer_nama'      => $customer->nama,
            'customer_email'     => $customer->email
        ]);

        // ===============================
        // REDIRECT KE HALAMAN ASAL
        // ===============================
        $redirect = $this->session->userdata('redirect_after_login');

        if ($redirect) {
            $this->session->unset_userdata('redirect_after_login');
            redirect($redirect);
        } else {
            redirect('akun');
        }
    }

    // ==================================================
    // REGISTER
    // ==================================================
    public function register()
    {
        if ($this->session->userdata('customer_logged_in')) {
            redirect('akun');
            return;
        }

        $data['title']   = 'Register | Zettarig';
        $data['content'] = 'web/auth/register';
        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // PROSES REGISTER
    // ==================================================
    public function process_register()
    {
        $nama     = $this->security->xss_clean($this->input->post('nama'));
        $email    = $this->security->xss_clean($this->input->post('email'));
        $password = $this->input->post('password');
        $no_hp    = $this->security->xss_clean($this->input->post('no_hp'));
        $alamat   = $this->security->xss_clean($this->input->post('alamat'));

        if (!$nama || !$email || !$password || !$no_hp || !$alamat) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi.');
            redirect('auth/register');
            return;
        }

        $exists = $this->db
            ->where('email', $email)
            ->count_all_results('customer');

        if ($exists > 0) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar.');
            redirect('auth/register');
            return;
        }

        $this->db->insert('customer', [
            'nama'          => $nama,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'no_hp'         => $no_hp,
            'alamat'        => $alamat,
            'status_aktif'  => 1
        ]);

        $this->session->set_flashdata(
            'success',
            'Registrasi berhasil. Silakan login.'
        );

        redirect('auth/login');
    }

    // ==================================================
    // LOGOUT (FIXED: UNSET USERDATA ONLY)
    // ==================================================
    public function logout()
    {
        // Hapus hanya data spesifik customer, biarkan admin tetap login
        $this->session->unset_userdata([
            'customer_logged_in', 
            'customer_id', 
            'customer_nama', 
            'customer_email'
        ]);
        
        $this->session->set_flashdata('success', 'Anda berhasil logout.');
        redirect('auth/login');
    }
}