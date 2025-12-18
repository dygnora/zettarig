<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    // ==================================================
    // LOGIN
    // ==================================================
    public function login()
    {
        // kalau sudah login, langsung ke checkout
        if ($this->session->userdata('customer_login')) {
            redirect('checkout');
        }

        $data['title']   = 'Login | Zettarig';
        $data['content'] = 'web/auth/login';
        $this->load->view('web/layout/template', $data);
    }

    public function process_login()
    {
        $email    = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        $customer = $this->Customer_model->get_by_email($email);

        if (!$customer || !password_verify($password, $customer->password)) {
            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('auth/login');
            return;
        }

        if ($customer->status_aktif != 1) {
            $this->session->set_flashdata('error', 'Akun tidak aktif.');
            redirect('auth/login');
            return;
        }

        // set session
        $this->session->set_userdata([
            'customer_id'    => $customer->id_customer,
            'customer_nama'  => $customer->nama,
            'customer_login' => true
        ]);

        redirect('checkout');
    }

    // ==================================================
    // REGISTER
    // ==================================================
    public function register()
    {
        $data['title']   = 'Register | Zettarig';
        $data['content'] = 'web/auth/register';
        $this->load->view('web/layout/template', $data);
    }

    public function process_register()
    {
        $data = [
            'nama_customer' => $this->input->post('nama', true),
            'email'         => $this->input->post('email', true),
            'password'      => password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            ),
            'no_hp'         => $this->input->post('no_hp', true),
            'alamat'        => $this->input->post('alamat', true),
            'status_aktif'  => 1
        ];

        // cek email
        if ($this->Customer_model->get_by_email($data['email'])) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar.');
            redirect('auth/register');
            return;
        }

        $this->Customer_model->insert($data);
        $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
        redirect('auth/login');
    }

    // ==================================================
    // LOGOUT
    // ==================================================
    public function logout()
    {
        $this->session->unset_userdata([
            'customer_id',
            'customer_nama',
            'customer_login'
        ]);
        redirect('produk');
    }
}
