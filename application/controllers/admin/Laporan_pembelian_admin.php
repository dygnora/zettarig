<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Laporan_pembelian_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_pembelian_model');
    }

    // ==================================================
    // 1. INDEX LAPORAN PEMBELIAN SUPPLIER
    // ==================================================
    public function index()
    {
        $data = $this->data;
        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        $data['title'] = 'Laporan Pembelian Supplier';
        $data['start'] = $start;
        $data['end']   = $end;
        $data['laporan'] = $this->Laporan_pembelian_model->laporan_pembelian_supplier($start, $end);

        $data['content'] = 'admin/laporan_pembelian/index';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // 2. DETAIL LAPORAN PEMBELIAN PER SUPPLIER
    // ==================================================
    public function supplier($id_supplier)
    {
        $data = $this->data;
        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        $supplier = $this->db->get_where('supplier', ['id_supplier' => $id_supplier])->row();
        if (!$supplier) show_404();

        $data['title']    = 'Detail Laporan Pembelian Supplier';
        $data['supplier'] = $supplier;
        $data['start']    = $start;
        $data['end']      = $end;
        $data['detail']   = $this->Laporan_pembelian_model->detail_pembelian_supplier($id_supplier, $start, $end);

        $data['content'] = 'admin/laporan_pembelian/detail';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // 3. EXPORT PDF GLOBAL
    // ==================================================
    public function export_pdf()
    {
        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        $data['laporan'] = $this->Laporan_pembelian_model->laporan_pembelian_supplier($start, $end);
        $data['start']   = $start;
        $data['end']     = $end;

        require_once APPPATH.'third_party/dompdf/autoload.inc.php';
        $dompdf = new Dompdf();
        
        $html = $this->load->view('admin/laporan_pembelian/export_pdf', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Pembelian_Supplier.pdf', ['Attachment' => false]);
    }

    // ==================================================
    // 4. EXPORT EXCEL GLOBAL (STYLE BARU)
    // ==================================================
    public function export_excel()
    {
        $start = $this->input->get('start');
        $end   = $this->input->get('end');
        $laporan = $this->Laporan_pembelian_model->laporan_pembelian_supplier($start, $end);

        $filename = 'Laporan_Pembelian_Supplier_' . date('d_m_Y') . '.xls';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #000000; padding: 8px; vertical-align: middle; }
                th { background-color: #4CAF50; color: white; text-align: center; height: 35px; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 5px; }
                .subtitle { font-size: 14px; text-align: center; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class="title">LAPORAN PEMBELIAN SUPPLIER</div>
            <div class="subtitle">
                Periode: <?= ($start && $end) ? date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end)) : 'Semua Waktu'; ?>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="250">Nama Supplier</th>
                        <th width="150">Jumlah Transaksi</th>
                        <th width="200">Total Pembelian (Rp)</th>
                        <th width="150">Transaksi Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan)): ?>
                        <?php $no = 1; foreach ($laporan as $r): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $r->nama_supplier; ?></td>
                            <td class="text-center"><?= $r->total_transaksi; ?></td>
                            <td class="text-right"><?= number_format($r->total_pembelian, 0, ',', '.'); ?></td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($r->tanggal_terakhir)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php $grand_total = array_sum(array_column($laporan, 'total_pembelian')); ?>
                        <tr style="background-color: #FFFF00; font-weight: bold;">
                            <td colspan="3" class="text-right">TOTAL PEMBELIAN</td>
                            <td class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></td>
                            <td></td>
                        </tr>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </body>
        </html>
        <?php
        exit;
    }

    // ==================================================
    // 5. EXPORT PDF DETAIL (PER SUPPLIER)
    // ==================================================
    public function export_pdf_supplier($id_supplier)
    {
        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        $supplier = $this->db->get_where('supplier', ['id_supplier' => $id_supplier])->row();
        if (!$supplier) show_404();

        $data['supplier'] = $supplier;
        $data['start']    = $start;
        $data['end']      = $end;
        $data['detail']   = $this->Laporan_pembelian_model->detail_pembelian_supplier($id_supplier, $start, $end);

        require_once APPPATH.'third_party/dompdf/autoload.inc.php';
        $dompdf = new Dompdf();

        $html = $this->load->view('admin/laporan_pembelian/export_pdf_supplier', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Detail_' . $supplier->nama_supplier . '.pdf', ['Attachment' => false]);
    }

    // ==================================================
    // 6. EXPORT EXCEL DETAIL (PROFESSIONAL REDESIGN)
    // ==================================================
    public function export_excel_supplier($id_supplier)
    {
        $start = $this->input->get('start');
        $end   = $this->input->get('end');

        // 1. Ambil Data
        $supplier = $this->db->get_where('supplier', ['id_supplier' => $id_supplier])->row();
        if (!$supplier) show_404();

        $detail = $this->Laporan_pembelian_model->detail_pembelian_supplier($id_supplier, $start, $end);

        // 2. Setup Filename & Headers
        // Membersihkan nama file dari karakter aneh
        $clean_name = preg_replace('/[^a-zA-Z0-9]/', '_', $supplier->nama_supplier);
        $filename   = 'Laporan_Pembelian_' . $clean_name . '_' . date('Ymd_Hi') . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // 3. Setup Variabel Tampilan
        $periode_label = ($start && $end) 
            ? date('d M Y', strtotime($start)) . ' s/d ' . date('d M Y', strtotime($end)) 
            : 'Semua Riwayat';
            
        // Warna Tema (Ganti kode HEX ini jika ingin warna lain, misal Hijau Excel: #217346)
        $theme_color = '#1F4E79'; 
        $theme_text  = '#FFFFFF';
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="utf-8">
            <title>Laporan Pembelian</title>
            <style>
                /* Reset & Font Dasar */
                body { font-family: 'Calibri', 'Arial', sans-serif; font-size: 11pt; color: #000000; }
                table { border-collapse: collapse; width: 100%; }
                
                /* Styling Judul Utama */
                .title-row { font-size: 16pt; font-weight: bold; text-align: center; height: 30px; }
                
                /* Styling Meta Info (Supplier, Tgl, dll) */
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
                
                /* Zebra Striping (Baris Genap beda warna) */
                .even-row { background-color: #EBF1DE; } /* Warna hijau/abu sangat muda */
                
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
                .bold { font-weight: bold; }
            </style>
        </head>
        <body>
            
            <table>
                <tr>
                    <td colspan="6" class="title-row" style="border: none;">LAPORAN DETAIL PEMBELIAN SUPPLIER</td>
                </tr>
                <tr><td colspan="6" style="border: none; height: 10px;"></td></tr>

                <tr>
                    <td style="border: none; width: 150px;" class="meta-label">Nama Supplier</td>
                    <td colspan="5" style="border: none;" class="meta-value">: <?= strtoupper($supplier->nama_supplier); ?></td>
                </tr>
                <tr>
                    <td style="border: none;" class="meta-label">Periode</td>
                    <td colspan="5" style="border: none;" class="meta-value" style="mso-number-format:'\@'">: <?= $periode_label; ?></td>
                </tr>
                <tr>
                    <td style="border: none;" class="meta-label">Tanggal Cetak</td>
                    <td colspan="5" style="border: none;" class="meta-value">: <?= date('d F Y, H:i'); ?> WIB</td>
                </tr>
                <tr><td colspan="6" style="border: none; height: 15px;"></td></tr>
            </table>

            <table border="1">
                <thead>
                    <tr>
                        <th class="thead" width="50">NO</th>
                        <th class="thead" width="120">TANGGAL</th>
                        <th class="thead" width="350">NAMA PRODUK</th>
                        <th class="thead" width="80">QTY</th>
                        <th class="thead" width="150">HARGA (RP)</th>
                        <th class="thead" width="180">SUBTOTAL (RP)</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $no = 1; 
                    $grand_total = 0;
                    
                    if (!empty($detail)): 
                        foreach ($detail as $key => $d): 
                        $grand_total += $d->subtotal;
                        // Logika Zebra Striping (Baris genap diberi warna beda)
                        $row_class = ($key % 2 == 1) ? 'background-color: #f2f2f2;' : ''; 
                    ?>
                        <tr>
                            <td class="text-center" style="<?= $row_class ?>"><?= $no++; ?></td>
                            
                            <td class="text-center" style="<?= $row_class ?> mso-number-format:'dd\/mm\/yyyy';">
                                <?= date('d/m/Y', strtotime($d->tanggal_pembelian)); ?>
                            </td>
                            
                            <td class="text-left" style="<?= $row_class ?>"><?= $d->nama_produk; ?></td>
                            
                            <td class="text-center" style="<?= $row_class ?>"><?= $d->jumlah_beli; ?></td>
                            
                            <td class="text-right" style="<?= $row_class ?> mso-number-format:'\#\,\#\#0';">
                                <?= $d->harga_modal_satuan; ?>
                            </td>
                            
                            <td class="text-right" style="<?= $row_class ?> mso-number-format:'\#\,\#\#0';">
                                <?= $d->subtotal; ?>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 20px; font-style: italic;">
                                -- Tidak ada data ditemukan pada periode ini --
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5" class="tfoot text-right">GRAND TOTAL</td>
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