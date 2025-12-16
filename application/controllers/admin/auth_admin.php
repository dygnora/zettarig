<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_admin extends MY_Controller
{
    // Auth tidak butuh proteksi login
    protected $is_admin = false;

    public function login()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            exit;
        }

        $this->load->view('admin/auth/login');
    }

    public function process()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        if (!$username || !$password) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi');
            redirect('admin/auth/login');
            exit;
        }

        // Ambil admin aktif
        $admin = $this->db
            ->where('username', $username)
            ->where('status_aktif', 1)
            ->get('admin')
            ->row();

        if ($admin && password_verify($password, $admin->password_hash)) {

            // Set session admin
            $this->session->set_userdata([
                'admin_logged_in' => true,
                'admin_id'        => $admin->id_admin,
                'admin_username'  => $admin->username,
                'admin_nama'      => $admin->nama_lengkap,
                'admin_email'     => $admin->email
            ]);

            // Update last login
            $this->db
                ->where('id_admin', $admin->id_admin)
                ->update('admin', [
                    'last_login' => date('Y-m-d H:i:s')
                ]);

            redirect('admin/dashboard');
            exit;
        }

        $this->session->set_flashdata('error', 'Username atau password salah');
        redirect('admin/auth/login');
        exit;
    }
    // fungsi logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/auth/login');
        exit;
    }
}
