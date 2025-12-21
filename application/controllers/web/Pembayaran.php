<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Proteksi login customer
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            exit;
        }

        $this->load->model(['Penjualan_model']);
        $this->load->library(['upload']);
        $this->load->helper(['url']);
    }

    // ==================================================
    // FORM UPLOAD BUKTI TRANSFER (FULL PAYMENT)
    // ==================================================
    public function upload($id_penjualan)
    {
        $customer_id = $this->session->userdata('customer_id');

        $pesanan = $this->Penjualan_model
            ->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan || $pesanan->metode_pembayaran !== 'transfer') {
            show_404();
            return;
        }

        $data['title']   = 'Upload Bukti Transfer';
        $data['pesanan'] = $pesanan;
        $data['content'] = 'web/pembayaran/upload'; 

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // PROSES UPLOAD TRANSFER (FULL PAYMENT)
    // ==================================================
    public function process($id_penjualan)
    {
        $customer_id = $this->session->userdata('customer_id');

        // 1. Ambil Data Pesanan (PENTING: Kita butuh total_harga)
        $pesanan = $this->Penjualan_model
            ->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan || $pesanan->metode_pembayaran !== 'transfer') {
            show_404(); return;
        }

        // 2. Config Upload
        $config['upload_path']   = FCPATH . 'assets/uploads/bukti_transfer/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti_transfer')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('pembayaran/upload/'.$id_penjualan);
            return;
        }

        $file = $this->upload->data();

        // 3. Cek & Update Database
        // Cek apakah sudah ada record (biasanya sudah dibuat saat checkout dgn nilai 0)
        $existing = $this->db->get_where('pembayaran_transfer', ['id_penjualan' => $id_penjualan])->row();
        
        if ($existing) {
             // [PERBAIKAN DISINI] 
             // Kita update 'jumlah_dibayar' sesuai total_harga pesanan agar tidak 0
             $this->db->where('id_penjualan', $id_penjualan)
                      ->update('pembayaran_transfer', [
                          'bukti_transfer'    => $file['file_name'],
                          'jumlah_dibayar'    => $pesanan->total_harga, // <--- INI PERBAIKANNYA
                          'status_verifikasi' => 'menunggu',
                          'tanggal_upload'    => date('Y-m-d H:i:s')
                      ]);
        } else {
             // Jika insert baru (fallback)
             $this->db->insert('pembayaran_transfer', [
                'id_penjualan'      => $id_penjualan,
                'bukti_transfer'    => $file['file_name'],
                'jumlah_dibayar'    => $pesanan->total_harga,
                'status_verifikasi' => 'menunggu',
                'tanggal_upload'    => date('Y-m-d H:i:s')
            ]);
        }

        // 4. Update Status Pesanan Utama
        $this->db->where('id_penjualan', $id_penjualan)
                 ->update('penjualan', ['status_pesanan' => 'menunggu_verifikasi']);

        // 5. Catat Timeline
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id_penjualan,
            'status_tahap' => 'Upload Bukti Transfer',
            'catatan'      => 'Customer mengupload bukti transfer senilai Rp ' . number_format($pesanan->total_harga)
        ]);

        $this->session->set_flashdata('success', 'Bukti transfer berhasil diupload.');
        redirect('akun/pesanan/detail/'.$id_penjualan);
    }


    // ==================================================
    // PROSES UPLOAD DP COD
    // ==================================================
    public function process_dp()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $customer_id  = $this->session->userdata('customer_id');

        // Validasi
        $pesanan = $this->Penjualan_model->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan || $pesanan->metode_pembayaran !== 'cod') {
            show_404(); return;
        }

        // Cek Tabel COD
        $cod_data = $this->db->get_where('pembayaran_cod', ['id_penjualan' => $id_penjualan])->row();
        if (!$cod_data) {
            show_error('Data tagihan COD tidak ditemukan.');
        }

        // Upload Config (Folder Beda: bukti_dp)
        $config['upload_path']   = FCPATH . 'assets/uploads/bukti_dp/';
        if (!is_dir($config['upload_path'])) { mkdir($config['upload_path'], 0777, true); }
        
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti_dp')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('akun/pesanan/detail/'.$id_penjualan);
            return;
        }

        $file = $this->upload->data();

        // Update Tabel COD
        // Catatan: dp_dibayar untuk COD diupdate oleh Admin saat Verifikasi, bukan saat upload.
        $this->db->where('id_cod', $cod_data->id_cod)
                 ->update('pembayaran_cod', [
                     'bukti_dp'          => $file['file_name'],
                     'tanggal_upload_dp' => date('Y-m-d H:i:s'),
                     'status_dp'         => 'menunggu' // Reset status agar admin cek
                 ]);
        
        // Update Status Pesanan
        $this->db->where('id_penjualan', $id_penjualan)
                 ->update('penjualan', ['status_pesanan' => 'menunggu_verifikasi']);

        // Timeline
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id_penjualan,
            'status_tahap' => 'Upload Bukti Transfer',
            'catatan'      => 'Customer mengupload bukti transfer DP'
        ]);

        $this->session->set_flashdata('success', 'Bukti DP berhasil diupload. Menunggu verifikasi.');
        redirect('akun/pesanan/detail/'.$id_penjualan);
    }
}