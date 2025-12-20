<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['cart', 'session']);
        $this->load->helper('url');

        // Jika keranjang kosong, tendang ke halaman produk
        if ($this->cart->total_items() <= 0) {
            redirect('produk');
        }
    }

    public function index()
    {
        $data['title']   = 'Checkout | Zettarig';
        $data['content'] = 'web/checkout/index';
        $this->load->view('web/layout/template', $data);
    }

    public function process()
    {
        // 1. CEK LOGIN
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
        }

        // 2. CEK KERANJANG
        if ($this->cart->total_items() <= 0) {
            redirect('produk');
        }

        $this->load->model(['Produk_model']);

        $customer_id = $this->session->userdata('customer_id');
        $alamat      = $this->input->post('alamat', true);
        $metode      = $this->input->post('metode_pembayaran', true);
        $total_harga = $this->cart->total();

        // 3. VALIDASI METODE BAYAR
        if (!in_array($metode, ['transfer', 'cod'])) {
            $this->session->set_flashdata('error', 'Metode pembayaran tidak valid.');
            redirect('checkout');
            return;
        }

        // 4. [LOGIC BARU] CEK WHITELIST COD
        // Kita cek apakah user ini boleh COD atau tidak
        if ($metode === 'cod') {
            $customer = $this->db->get_where('customer', ['id_customer' => $customer_id])->row();
            
            // Jika is_cod_allowed = 0, tolak pesanan
            if ($customer->is_cod_allowed == 0) {
                $this->session->set_flashdata('error', 'Akun Anda tidak diizinkan menggunakan COD. Silakan pilih Transfer.');
                redirect('checkout');
                return;
            }
        }

        // 5. MULAI TRANSAKSI DATABASE
        // Gunakan trans_begin agar bisa rollback manual jika stok habis
        $this->db->trans_begin();

        // Tentukan Status Awal
        // Default: Transfer = menunggu_pembayaran, COD = dibuat
        // Nanti jika COD butuh DP, statusnya akan kita ubah jadi 'menunggu_pembayaran' di bawah
        $status_pesanan = ($metode === 'transfer') ? 'menunggu_pembayaran' : 'dibuat';

        // ================= A. INSERT HEADER PENJUALAN =================
        $penjualan = [
            'id_customer'       => $customer_id,
            'tanggal_pesanan'   => date('Y-m-d H:i:s'),
            'total_harga'       => $total_harga,
            'metode_pembayaran' => $metode,
            'status_pesanan'    => $status_pesanan, // Status sementara
            'alamat_pengiriman' => $alamat
        ];

        $this->db->insert('penjualan', $penjualan);
        $id_penjualan = $this->db->insert_id();

        // ================= B. INSERT DETAIL + CEK STOK =================
        foreach ($this->cart->contents() as $item) {

            // Ambil data produk terbaru untuk cek stok real-time
            $produk = $this->Produk_model->get_by_id($item['id']);
            
            // Jika produk hilang atau stok kurang, batalkan semua transaksi
            if (!$produk || $produk->stok < $item['qty']) {
                $this->db->trans_rollback(); // Batalkan insert penjualan
                $this->session->set_flashdata(
                    'error',
                    'Stok produk tidak mencukupi: ' . $item['name'] . ' (Sisa: ' . ($produk->stok ?? 0) . ')'
                );
                redirect('cart');
                return;
            }

            // Insert Detail
            $this->db->insert('detail_penjualan', [
                'id_penjualan' => $id_penjualan,
                'id_produk'    => $item['id'],
                'jumlah'       => $item['qty'],
                'harga_satuan' => $item['price'],
                'subtotal'     => $item['subtotal']
            ]);

            // Potong Stok
            $this->Produk_model->kurangi_stok($item['id'], $item['qty']);
        }

        // ================= C. [LOGIC BARU] INSERT TABEL PEMBAYARAN =================
        
        // --- JIKA TRANSFER ---
        if ($metode === 'transfer') {
            $this->db->insert('pembayaran_transfer', [
                'id_penjualan'      => $id_penjualan,
                'jumlah_dibayar'    => 0, // Awalnya 0
                'status_verifikasi' => 'menunggu'
            ]);
        }
        
        // --- JIKA COD ---
        elseif ($metode === 'cod') {
            
            // Aturan DP: Jika di atas 5 Juta, Wajib DP 20%
            $batas_wajib_dp = 5000000;
            $dp_wajib       = 0;
            
            if ($total_harga > $batas_wajib_dp) {
                $dp_wajib = $total_harga * 0.20; // 20%
            }

            // Insert ke tabel pembayaran_cod (PENTING AGAR MUNCUL DI ADMIN COD)
            $this->db->insert('pembayaran_cod', [
                'id_penjualan'      => $id_penjualan,
                'dp_wajib'          => $dp_wajib,
                'dp_dibayar'        => 0,
                'sisa_pembayaran'   => ($total_harga - $dp_wajib),
                // Jika tidak ada DP, status langsung diterima. Jika ada DP, menunggu.
                'status_dp'         => ($dp_wajib > 0) ? 'menunggu' : 'diterima',
                'status_pelunasan'  => 'belum'
            ]);

            // Jika Wajib DP, ubah status pesanan utama jadi 'menunggu_pembayaran'
            // Karena user harus upload bukti DP dulu
            if ($dp_wajib > 0) {
                $this->db->where('id_penjualan', $id_penjualan)
                         ->update('penjualan', ['status_pesanan' => 'menunggu_pembayaran']);
                
                // Update variabel status lokal untuk timeline
                $status_pesanan = 'menunggu_pembayaran';
            }
        }

        // ================= D. INSERT TIMELINE =================
        
        // Tentukan catatan timeline berdasarkan logika di atas
        $catatan_timeline = '';
        if ($metode === 'transfer') {
            $catatan_timeline = 'Menunggu upload bukti transfer';
        } elseif ($metode === 'cod') {
            if (isset($dp_wajib) && $dp_wajib > 0) {
                $catatan_timeline = 'Pesanan > 5 Juta. Menunggu Pembayaran DP 20%';
            } else {
                $catatan_timeline = 'Pesanan COD dibuat (Siap Diproses)';
            }
        }

        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id_penjualan,
            'status_tahap' => 'Pesanan Dibuat',
            'catatan'      => $catatan_timeline
        ]);

        // ================= CEK STATUS TRANSAKSI DB =================
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Gagal memproses pesanan. Silakan coba lagi.');
            redirect('checkout');
            return;
        }

        // Jika Sukses Semua
        $this->db->trans_commit();
        $this->cart->destroy(); // Kosongkan keranjang

        // Redirect ke Detail Pesanan
        redirect('akun/pesanan/detail/'.$id_penjualan);
    }
}