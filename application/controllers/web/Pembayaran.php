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
        $this->load->library(['upload', 'session']);
        $this->load->helper(['url', 'file']);
    }

    // ==================================================
    // 1. PROSES UPLOAD BUKTI BAYAR (TRANSFER FULL)
    // ==================================================
    public function process_upload()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $customer_id  = $this->session->userdata('customer_id');

        if (empty($id_penjualan)) { show_404(); return; }

        // 1. Ambil Data Pesanan
        $pesanan = $this->Penjualan_model->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan || $pesanan->metode_pembayaran !== 'transfer') {
            $this->session->set_flashdata('error', 'Metode pembayaran tidak valid.');
            redirect('akun/pesanan/detail/'.$id_penjualan);
            return;
        }

        // 2. Config Upload
        $path = FCPATH . 'assets/uploads/bukti_transfer/';
        if (!is_dir($path)) { mkdir($path, 0777, true); }

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 5120; // 5MB
        $config['file_name']     = 'TF_' . $id_penjualan . '_' . time(); // Nama unik
        $config['overwrite']     = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti_bayar')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('akun/pesanan/detail/'.$id_penjualan);
            return;
        }

        $file = $this->upload->data();

        // 3. Cek Database (Update or Insert)
        $existing = $this->db->get_where('pembayaran_transfer', ['id_penjualan' => $id_penjualan])->row();
        
        // Hapus file lama jika ada (untuk hemat storage)
        if ($existing && !empty($existing->bukti_transfer)) {
            $old_file = $path . $existing->bukti_transfer;
            if (file_exists($old_file)) { unlink($old_file); }
        }

        if ($existing) {
             // Update
             $this->db->where('id_penjualan', $id_penjualan)
                      ->update('pembayaran_transfer', [
                          'bukti_transfer'    => $file['file_name'],
                          'jumlah_dibayar'    => $pesanan->total_harga,
                          'status_verifikasi' => 'menunggu',
                          'tanggal_upload'    => date('Y-m-d H:i:s')
                      ]);
        } else {
             // Insert Baru
             $this->db->insert('pembayaran_transfer', [
                'id_penjualan'      => $id_penjualan,
                'bukti_transfer'    => $file['file_name'],
                'jumlah_dibayar'    => $pesanan->total_harga,
                'status_verifikasi' => 'menunggu',
                'tanggal_upload'    => date('Y-m-d H:i:s')
            ]);
        }

        // 4. Update Status Pesanan -> Menunggu Verifikasi
        $this->db->where('id_penjualan', $id_penjualan)
                 ->update('penjualan', ['status_pesanan' => 'menunggu_verifikasi']);

        // 5. Catat Timeline
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id_penjualan,
            'status_tahap' => 'Upload Bukti Transfer',
            'catatan'      => 'Customer mengupload bukti transfer Full Payment.',
            'waktu'        => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Bukti transfer berhasil dikirim. Mohon tunggu verifikasi admin.');
        redirect('akun/pesanan/detail/'.$id_penjualan);
    }


    // ==================================================
    // 2. PROSES UPLOAD BUKTI DP (COD)
    // ==================================================
    public function process_dp()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $customer_id  = $this->session->userdata('customer_id');

        if (empty($id_penjualan)) { show_404(); return; }

        // Validasi
        $pesanan = $this->Penjualan_model->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan || $pesanan->metode_pembayaran !== 'cod') {
            $this->session->set_flashdata('error', 'Metode pembayaran bukan COD.');
            redirect('akun/pesanan/detail/'.$id_penjualan);
            return;
        }

        // Cek Tabel COD
        $cod_data = $this->db->get_where('pembayaran_cod', ['id_penjualan' => $id_penjualan])->row();
        if (!$cod_data) {
            // Seharusnya data COD sudah dibuat saat checkout. Jika tidak ada, buat manual (fallback).
            $this->session->set_flashdata('error', 'Data tagihan COD tidak ditemukan. Hubungi Admin.');
            redirect('akun/pesanan/detail/'.$id_penjualan);
            return;
        }

        // Upload Config
        $path = FCPATH . 'assets/uploads/bukti_dp/';
        if (!is_dir($path)) { mkdir($path, 0777, true); }
        
        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 5120; // 5MB
        $config['file_name']     = 'DP_' . $id_penjualan . '_' . time();
        $config['overwrite']     = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti_dp')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('akun/pesanan/detail/'.$id_penjualan);
            return;
        }

        $file = $this->upload->data();

        // Hapus file lama jika ada
        if (!empty($cod_data->bukti_dp)) {
            $old_file = $path . $cod_data->bukti_dp;
            if (file_exists($old_file)) { unlink($old_file); }
        }

        // Update Tabel COD
        $this->db->where('id_cod', $cod_data->id_cod)
                 ->update('pembayaran_cod', [
                     'bukti_dp'          => $file['file_name'],
                     'tanggal_upload_dp' => date('Y-m-d H:i:s'),
                     'status_dp'         => 'menunggu' // Reset status agar admin cek ulang
                 ]);
        
        // Update Status Pesanan Utama
        $this->db->where('id_penjualan', $id_penjualan)
                 ->update('penjualan', ['status_pesanan' => 'menunggu_verifikasi']);

        // Timeline
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id_penjualan,
            'status_tahap' => 'Upload Bukti DP',
            'catatan'      => 'Customer mengupload bukti transfer DP COD.',
            'waktu'        => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Bukti DP berhasil dikirim. Menunggu verifikasi.');
        redirect('akun/pesanan/detail/'.$id_penjualan);
    }
}