<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Memanggil library Dompdf untuk export PDF
use Dompdf\Dompdf;

class Laporan_admin extends MY_Controller
{
    // Properti ini memastikan hanya admin yang bisa mengakses controller ini
    // (Logic pengecekan ada di core/MY_Controller.php)
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        // Load model khusus laporan untuk mengambil data penjualan & customer
        $this->load->model('Laporan_model');
    }

    // ==================================================
    // 1. HALAMAN UTAMA LAPORAN (Rekap per Customer)
    // ==================================================
    public function index()
    {
        $data = $this->data; // Ambil data global (user session, notifikasi, dll)

        // Ambil filter dari URL (GET request)
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        $data['title']   = 'Laporan Penjualan';
        
        // Lempar data filter ke view agar input date tetap terisi setelah submit
        $data['mode']    = $mode;
        $data['start']   = $start;
        $data['end']     = $end;

        // Ambil data laporan yang sudah dikelompokkan per user
        $data['laporan'] = $this->Laporan_model
            ->laporan_penjualan_group_user($mode, $start, $end);

        $data['content'] = 'admin/laporan/index';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // 2. DETAIL LAPORAN PER CUSTOMER (Drill Down)
    // ==================================================
    public function user($id_customer)
    {
        $data = $this->data;

        // Ambil filter tanggal agar detail yang muncul sesuai periode yang dipilih di awal
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        // Cek apakah customer ada
        $customer = $this->Laporan_model->get_customer($id_customer);
        if (!$customer) show_404();

        $data['title']    = 'Detail Laporan Customer';
        $data['customer'] = $customer;
        
        // Pass filter ke view detail juga
        $data['mode']     = $mode;
        $data['start']    = $start;
        $data['end']      = $end;

        // Ambil detail transaksi spesifik user tersebut
        $data['detail']   = $this->Laporan_model
            ->detail_penjualan_user($id_customer, $mode, $start, $end);

        $data['content'] = 'admin/laporan/detail_user';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // 3. EXPORT PDF (Menggunakan Library Dompdf)
    // ==================================================
    public function export_pdf()
    {
        // Ambil filter
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        // Ambil data sesuai filter
        $data['laporan'] = $this->Laporan_model
            ->laporan_penjualan_group_user($mode, $start, $end);
        
        // Info periode untuk judul di PDF
        $data['start'] = $start;
        $data['end']   = $end;

        // Load library Dompdf manual (sesuai path di folder third_party Anda)
        // Jika error, pastikan path file autoload.inc.php benar.
        require_once APPPATH.'third_party/dompdf/autoload.inc.php';

        $dompdf = new Dompdf();
        
        // Load view khusus untuk PDF (buat file view ini jika belum ada)
        $html   = $this->load->view('admin/laporan/export_pdf', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Ukuran kertas A4 tegak
        $dompdf->render();
        
        // Stream: Download file ke browser user
        $dompdf->stream('Laporan_Penjualan.pdf', ['Attachment' => false]);
    }

    // ==================================================
    // 4. EXPORT EXCEL (Format HTML Table) - SUDAH DIPERBAIKI
    // ==================================================
    public function export_excel()
    {
        // 1. Ambil Filter Data
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        // 2. Query Data dari Model
        $laporan = $this->Laporan_model
            ->laporan_penjualan_group_user($mode, $start, $end);

        // 3. Setup Header HTTP agar browser mengenali file Excel
        $filename = 'Laporan_Penjualan_' . date('d_m_Y_His') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // 4. Generate Tabel HTML dengan Styling CSS Internal
        // Excel versi lama hingga baru bisa membaca HTML Table dengan baik.
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; }
                table { border-collapse: collapse; width: 100%; }
                /* Border Hitam Tegas di setiap sel */
                th, td { border: 1px solid #000000; padding: 8px; vertical-align: middle; }
                
                /* Styling Header Tabel (Warna Hijau Excel) */
                th { 
                    background-color: #4CAF50; 
                    color: white; 
                    font-weight: bold; 
                    text-align: center; 
                    height: 35px;
                }

                /* Warna selang-seling baris agar mudah dibaca */
                tr:nth-child(even) { background-color: #f2f2f2; }

                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 5px; }
                .subtitle { font-size: 14px; text-align: center; margin-bottom: 20px; }
            </style>
        </head>
        <body>

            <div class="title">LAPORAN PENJUALAN PER CUSTOMER</div>
            <div class="subtitle">
                Periode: 
                <?= ($start && $end) ? date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end)) : 'Semua Waktu'; ?>
            </div>
            <br>

            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="250">Nama Customer</th>
                        <th width="150">Jumlah Transaksi</th>
                        <th width="200">Total Belanja (Rp)</th>
                        <th width="150">Transaksi Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan)): ?>
                        <?php $no = 1; foreach ($laporan as $r): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $r->nama_customer; ?></td>
                            <td class="text-center"><?= $r->total_transaksi; ?></td>
                            
                            <td class="text-right">
                                <?= number_format($r->total_belanja, 0, ',', '.'); ?>
                            </td>
                            
                            <td class="text-center">
                                <?= date('d/m/Y', strtotime($r->tanggal_transaksi)); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php 
                            $grand_total = array_sum(array_column($laporan, 'total_belanja')); 
                        ?>
                        <tr style="background-color: #FFFF00; font-weight: bold;">
                            <td colspan="3" class="text-right">TOTAL PENDAPATAN</td>
                            <td class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></td>
                            <td></td>
                        </tr>

                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data penjualan pada periode ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </body>
        </html>
        <?php
        exit; // Hentikan script agar tidak ada output tambahan
    }

    // ==================================================
    // [BARU] EXPORT PDF DETAIL USER
    // ==================================================
    public function export_pdf_user($id_customer)
    {
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        $customer = $this->Laporan_model->get_customer($id_customer);
        if (!$customer) show_404();

        // Ambil data detail
        $data['detail'] = $this->Laporan_model
            ->detail_penjualan_user($id_customer, $mode, $start, $end);
        
        $data['customer'] = $customer;
        $data['start']    = $start;
        $data['end']      = $end;

        require_once APPPATH.'third_party/dompdf/autoload.inc.php';
        $dompdf = new Dompdf();

        // Load View PDF Khusus Detail (Kita buat on-the-fly atau view terpisah)
        // Disini saya gunakan view yang sama tapi kita kirim flag 'is_detail'
        $html = $this->load->view('admin/laporan/export_pdf_user', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Detail_'.$customer->nama.'.pdf', ['Attachment' => false]);
    }

    // ==================================================
    // 6. EXPORT EXCEL DETAIL CUSTOMER (PROFESSIONAL REDESIGN)
    // ==================================================
    public function export_excel_user($id_customer)
    {
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        // 1. Ambil Data Customer (Gunakan Laporan_model, BUKAN Laporan_pembelian_model)
        $customer = $this->Laporan_model->get_customer($id_customer);
        if (!$customer) show_404();

        // 2. Ambil Data Detail Penjualan
        $detail = $this->Laporan_model
            ->detail_penjualan_user($id_customer, $mode, $start, $end);

        // 3. Setup Filename & Headers
        $clean_name = preg_replace('/[^a-zA-Z0-9]/', '_', $customer->nama);
        $filename   = 'Laporan_Detail_' . $clean_name . '_' . date('Ymd_Hi') . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // 4. Setup Variabel Tampilan
        $periode_label = ($start && $end) 
            ? date('d M Y', strtotime($start)) . ' s/d ' . date('d M Y', strtotime($end)) 
            : 'Semua Riwayat';
            
        // Warna Tema (Biru Profesional)
        $theme_color = '#1F4E79'; 
        $theme_text  = '#FFFFFF';
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="utf-8">
            <title>Laporan Detail Transaksi Customer</title>
            <style>
                /* Reset & Font Dasar */
                body { font-family: 'Calibri', 'Arial', sans-serif; font-size: 11pt; color: #000000; }
                table { border-collapse: collapse; width: 100%; }
                
                /* Styling Judul Utama */
                .title-row { font-size: 16pt; font-weight: bold; text-align: center; height: 30px; }
                
                /* Styling Meta Info */
                .meta-label { font-weight: bold; text-align: left; vertical-align: top; }
                .meta-value { text-align: left; vertical-align: top; }
                
                /* Styling Table Header */
                .thead { 
                    background-color: <?= $theme_color ?>; 
                    color: <?= $theme_text ?>; 
                    font-weight: bold; 
                    text-align: center; 
                    vertical-align: middle;
                    border: 1px solid #000000;
                    height: 35px;
                }
                
                /* Styling Table Body */
                td { border: 1px solid #000000; padding: 5px; vertical-align: middle; }
                
                /* Zebra Striping */
                .even-row { background-color: #EBF1DE; } /* Hijau muda/abu */
                
                /* Styling Footer (Total) */
                .tfoot { 
                    background-color: #DDDDDD; 
                    font-weight: bold; 
                    border: 1px solid #000000;
                    color: #000000;
                }

                /* Helper Classes */
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .text-left { text-align: left; }
            </style>
        </head>
        <body>
            
            <table>
                <tr>
                    <td colspan="7" class="title-row" style="border: none;">LAPORAN DETAIL TRANSAKSI CUSTOMER</td>
                </tr>
                <tr><td colspan="7" style="border: none; height: 10px;"></td></tr>

                <tr>
                    <td colspan="2" style="border: none; width: 150px;" class="meta-label">Nama Customer</td>
                    <td colspan="5" style="border: none;" class="meta-value">: <?= strtoupper($customer->nama); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none;" class="meta-label">Periode</td>
                    <td colspan="5" style="border: none;" class="meta-value" style="mso-number-format:'\@'">: <?= $periode_label; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none;" class="meta-label">Tanggal Cetak</td>
                    <td colspan="5" style="border: none;" class="meta-value">: <?= date('d F Y, H:i'); ?> WIB</td>
                </tr>
                <tr><td colspan="7" style="border: none; height: 15px;"></td></tr>
            </table>

            <table border="1">
                <thead>
                    <tr>
                        <th class="thead" width="50">NO</th>
                        <th class="thead" width="120">TANGGAL</th>
                        <th class="thead" width="300">NAMA PRODUK</th>
                        <th class="thead" width="60">QTY</th>
                        <th class="thead" width="120">METODE</th>
                        <th class="thead" width="120">STATUS</th>
                        <th class="thead" width="150">SUBTOTAL (RP)</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $no = 1; 
                    $grand_total = 0;
                    
                    if (!empty($detail)): 
                        foreach ($detail as $key => $d): 
                        $grand_total += $d->subtotal;
                        
                        // Zebra Striping Logic
                        $row_style = ($key % 2 == 1) ? 'background-color: #EBF1DE;' : ''; 
                    ?>
                        <tr>
                            <td class="text-center" style="<?= $row_style ?>"><?= $no++; ?></td>
                            
                            <td class="text-center" style="<?= $row_style ?> mso-number-format:'dd\/mm\/yyyy';">
                                <?= date('d/m/Y', strtotime($d->tanggal_pesanan)); ?>
                            </td>
                            
                            <td class="text-left" style="<?= $row_style ?>"><?= $d->nama_produk; ?></td>
                            
                            <td class="text-center" style="<?= $row_style ?>"><?= $d->jumlah; ?></td>
                            
                            <td class="text-center" style="<?= $row_style ?>"><?= strtoupper($d->metode_pembayaran); ?></td>
                            
                            <td class="text-center" style="<?= $row_style ?>"><?= ucfirst($d->status_pesanan); ?></td>
                            
                            <td class="text-right" style="<?= $row_style ?> mso-number-format:'\#\,\#\#0';">
                                <?= $d->subtotal; ?>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 20px; font-style: italic;">
                                -- Tidak ada data transaksi ditemukan pada periode ini --
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="6" class="tfoot text-right">TOTAL TRANSAKSI</td>
                        <td class="tfoot text-right" style="mso-number-format:'\#\,\#\#0'; border-top: 2px double #000000;">
                            <?= $grand_total; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </body>
        </html>
        <?php
        exit;
    }
}