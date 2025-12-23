<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load library yang dibutuhkan secara global di class ini
        $this->load->library(['session', 'cart', 'email']);
        $this->load->database();
        $this->load->helper(['url', 'security']);
        
        // Set timezone agar perhitungan expired token akurat dengan waktu lokal
        date_default_timezone_set('Asia/Jakarta');
    }

    // ===============================
    // LOGIN PAGE
    // ===============================
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

    // ===============================
    // PROSES LOGIN
    // ===============================
    public function process_login()
{
    // 1. Ambil input 'username' bukan 'email'
    $username = $this->security->xss_clean($this->input->post('username'));
    $password = $this->input->post('password');

    // 2. Validasi input
    if (!$username || !$password) {
        $this->session->set_flashdata('error', 'Username dan password wajib diisi.');
        redirect('auth/login');
        return;
    }

    // 3. Cari user berdasarkan 'username' di database
    // Pastikan kolom 'username' ada di tabel 'customer' (sesuai DB Referensi.txt Anda)
    $customer = $this->db->get_where('customer', ['username' => $username])->row();

    // 4. Cek User & Password
    if ($customer) {
        // Cek Status Aktif
        if ($customer->status_aktif == 0) {
            $this->session->set_flashdata('error', 'Akun Anda telah dinonaktifkan.');
            redirect('auth/login');
            return;
        }

        // Verifikasi Password
        if (password_verify($password, $customer->password_hash)) {
            // Set Session
            $this->session->set_userdata([
                'customer_logged_in' => true,
                'customer_id'        => $customer->id_customer,
                'customer_nama'      => $customer->nama,
                'customer_username'  => $customer->username, // Simpan username di session
                'customer_email'     => $customer->email,
                'customer_foto'      => $customer->foto_profil
            ]);
            
            // Restore keranjang (jika ada logika ini)
            $this->load->model('Produk_model');
            $this->Produk_model->restore_cart_from_db($customer->id_customer);

            redirect('akun'); // Redirect ke dashboard
        } else {
            $this->session->set_flashdata('error', 'Password salah.');
            redirect('auth/login');
        }
    } else {
        $this->session->set_flashdata('error', 'Username tidak ditemukan.');
        redirect('auth/login');
    }
}

    // ===============================
    // REGISTER PAGE
    // ===============================
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

    public function process_register()
{
    // 1. Tangkap semua input (Termasuk Username yang sebelumnya tertinggal)
    $nama     = $this->security->xss_clean($this->input->post('nama'));
    $username = $this->security->xss_clean($this->input->post('username')); // <--- TAMBAHKAN INI
    $email    = $this->security->xss_clean($this->input->post('email'));
    $password = $this->input->post('password');
    $no_hp    = $this->security->xss_clean($this->input->post('no_hp'));
    $alamat   = $this->security->xss_clean($this->input->post('alamat'));

    // 2. Validasi field kosong
    if (!$nama || !$username || !$email || !$password || !$no_hp || !$alamat) {
        $this->session->set_flashdata('error', 'Semua field wajib diisi, termasuk Username.');
        redirect('auth/register');
        return;
    }

    // 3. Validasi Duplikasi Email & Username (Penting karena UNIQUE di database)
    $exists = $this->db->group_start()
                       ->where('email', $email)
                       ->or_where('username', $username)
                       ->group_end()
                       ->count_all_results('customer');

    if ($exists > 0) {
        $this->session->set_flashdata('error', 'Email atau Username sudah terdaftar.');
        redirect('auth/register');
        return;
    }

    // 4. Proses Insert ke Database
    $data = [
        'nama'          => $nama,
        'username'      => $username, // <--- Sekarang variabel ini sudah ada nilainya
        'email'         => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'no_hp'         => $no_hp,
        'alamat'        => $alamat,
        'status_aktif'  => 1,
        'foto_profil'   => 'default.jpg'
    ];

    if ($this->db->insert('customer', $data)) {
        $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
        redirect('auth/login');
    } else {
        $this->session->set_flashdata('error', 'Terjadi kegagalan sistem saat menyimpan data.');
        redirect('auth/register');
    }
}

    // ===============================
    // LOGOUT
    // ===============================
    public function logout()
    {
        $this->cart->destroy(); 
        $this->session->unset_userdata(['customer_logged_in', 'customer_id', 'customer_nama', 'customer_email', 'customer_foto']);
        $this->session->set_flashdata('success', 'Anda berhasil logout.');
        redirect('auth/login');
    }

    // ==================================================
    // FORGOT PASSWORD LOGIC (UPGRADED BIN2HEX)
    // ==================================================

    public function forgot_password()
    {
        $data['title']   = 'Lupa Password | Zettarig';
        $data['content'] = 'web/auth/forgot_password'; 
        $this->load->view('web/layout/template', $data);
    }

    public function process_forgot()
    {
        $email = $this->input->post('email', true);
        $user  = $this->db->get_where('customer', ['email' => $email, 'status_aktif' => 1])->row();

        if ($user) {
            // MENGGUNAKAN BIN2HEX: Dijamin aman untuk URL (hanya angka & huruf a-f)
            $token = bin2hex(random_bytes(32));
            
            $data_update = [
                'reset_token' => $token,
                'reset_token_expired' => date('Y-m-d H:i:s', time() + 3600) // 1 Jam
            ];
            
            $this->db->where('email', $email);
            $this->db->update('customer', $data_update);

            // Kirim Email
            $this->_sendEmail($token, $email);

            $this->session->set_flashdata('success', 'Sinyal pemulihan telah dikirim. Silakan cek email Anda.');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Email tidak terdaftar dalam database Zettarig.');
            redirect('auth/forgot_password');
        }
    }

    private function _sendEmail($token, $email)
    {
        // Otomatis mengambil konfigurasi dari application/config/email.php
        $this->email->from('zettarigstore@gmail.com', 'Zettarig Security');
        $this->email->to($email);
        $this->email->subject('RECOVERY: Reset Your Passcode');
        
        $link = base_url() . 'auth/reset_password?email=' . $email . '&token=' . $token;
        
        $message = "
        <div style='background:#050510; color:white; padding:30px; font-family:monospace; border: 2px solid #333;'>
            <h2 style='color:#00ffff; border-bottom: 1px solid #333; padding-bottom: 10px;'>[SYSTEM RECOVERY MODE]</h2>
            <p>Kami mendeteksi permintaan pengaturan ulang kode akses untuk akun Anda.</p>
            <p style='background:#111; padding:15px; border-left: 4px solid #ff00de;'>
                <strong>Email:</strong> $email<br>
                <strong>Expired:</strong> 1 Jam dari sekarang
            </p>
            <p>Silakan klik tombol di bawah untuk memasukkan kode akses baru:</p>
            <div style='text-align:center; margin:30px 0;'>
                <a href='$link' style='background:#ff00de; color:white; padding:15px 25px; text-decoration:none; display:inline-block; font-weight:bold; box-shadow: 4px 4px 0 #880070;'>INITIALIZE RESET</a>
            </div>
            <p style='font-size:11px; color:#555;'>Pesan ini dikirim secara otomatis oleh Zettarig Mainframe. Jika Anda tidak merasa melakukan permintaan ini, segera amankan akun Anda.</p>
        </div>";

        $this->email->message($message);

        if (!$this->email->send()) {
            return false;
        }
        return true;
    }

    public function reset_password()
{
    // Ambil data MENTAH dari URL (tanpa xss_clean otomatis agar karakter tidak berubah)
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    // Cari user berdasarkan email
    $user = $this->db->get_where('customer', ['email' => $email])->row();

    if ($user) {
        // Bandingkan token mentah dari DB dengan token mentah dari URL
        // Gunakan hash_equals untuk perbandingan string yang aman
        if ($user->reset_token === $token) {
            
            // Cek apakah sudah kadaluwarsa
            if (strtotime($user->reset_token_expired) > time()) {
                $this->session->set_userdata('reset_email', $email);
                
                $data['title'] = 'New Passcode | Zettarig';
                $data['content'] = 'web/auth/change_password';
                $this->load->view('web/layout/template', $data);
            } else {
                $this->session->set_flashdata('error', 'Sinyal token telah kedaluwarsa (Limit 1 Jam).');
                redirect('auth/login');
            }
        } else {
            // Jika tidak cocok, tampilkan error ini
            $this->session->set_flashdata('error', 'Token keamanan tidak valid atau telah dimanipulasi.');
            redirect('auth/login');
        }
    } else {
        $this->session->set_flashdata('error', 'Otoritas gagal: Email tidak dikenali.');
        redirect('auth/login');
    }
}

    public function process_change_password()
    {
        $email = $this->session->userdata('reset_email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');

        if (!$email) redirect('auth/login');

        if ($password != $conf_password) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok.');
            // Redirect kembali ke halaman input dengan parameter yang sama agar user tidak perlu ke email lagi
            $user = $this->db->get_where('customer', ['email' => $email])->row();
            redirect('auth/reset_password?email='.$email.'&token='.$user->reset_token);
            return;
        }

        $this->db->set('password_hash', password_hash($password, PASSWORD_DEFAULT));
        $this->db->set('reset_token', NULL);
        $this->db->set('reset_token_expired', NULL);
        $this->db->where('email', $email);
        $this->db->update('customer');

        $this->session->unset_userdata('reset_email');
        $this->session->set_flashdata('success', 'Kode akses diperbarui! Silakan kembali ke terminal login.');
        redirect('auth/login');
    }
}