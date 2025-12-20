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
    // FORM UPLOAD BUKTI TRANSFER
    // ==================================================
    public function upload($id_penjualan)
    {
        $customer_id = $this->session->userdata('customer_id');

        // Pastikan pesanan milik customer
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
    // PROSES UPLOAD BUKTI TRANSFER
    // ==================================================
    public function process($id_penjualan)
    {
        $customer_id = $this->session->userdata('customer_id');

        // Validasi kepemilikan pesanan
        $pesanan = $this->Penjualan_model
            ->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan || $pesanan->metode_pembayaran !== 'transfer') {
            show_404();
            return;
        }

        // ===============================
        // KONFIG UPLOAD
        // ===============================
        $config['upload_path'] = FCPATH . 'assets/uploads/bukti_transfer/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti_transfer')) {
            $this->session->set_flashdata(
                'error',
                $this->upload->display_errors('', '')
            );
            redirect('pembayaran/upload/'.$id_penjualan);
            return;
        }

        $file = $this->upload->data();

        // ===============================
        // SIMPAN KE DATABASE
        // ===============================
        $this->db->insert('pembayaran_transfer', [
            'id_penjualan'     => $id_penjualan,
            'bukti_transfer'   => $file['file_name'],
            'jumlah_dibayar'   => $pesanan->total_harga,
            'status_verifikasi'=> 'menunggu',
            'tanggal_upload'   => date('Y-m-d H:i:s')
        ]);

        // Update status pesanan
        $this->db->where('id_penjualan', $id_penjualan)
                 ->update('penjualan', [
                     'status_pesanan' => 'menunggu_verifikasi'
                 ]);

        // Timeline
        $this->db->insert('timeline_pesanan', [
            'id_penjualan' => $id_penjualan,
            'status_tahap' => 'Upload Bukti Transfer',
            'catatan'      => 'Customer mengupload bukti transfer'
        ]);

        $this->session->set_flashdata(
            'success',
            'Bukti transfer berhasil diupload. Menunggu verifikasi admin.'
        );

        redirect('akun/pesanan/detail/'.$id_penjualan);
    }
}
