<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Laporan_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
    }

    // ==================================================
    // INDEX LAPORAN
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        $data['title']   = 'Laporan Penjualan';
        $data['mode']    = $mode;
        $data['start']   = $start;
        $data['end']     = $end;
        $data['laporan'] = $this->Laporan_model
            ->laporan_penjualan_group_user($mode, $start, $end);

        $data['content'] = 'admin/laporan/index';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL LAPORAN PER CUSTOMER
    // ==================================================
    public function user($id_customer)
    {
        $data = $this->data;

        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        $customer = $this->Laporan_model->get_customer($id_customer);
        if (!$customer) show_404();

        $data['title']    = 'Detail Laporan Customer';
        $data['customer'] = $customer;
        $data['mode']     = $mode;
        $data['start']    = $start;
        $data['end']      = $end;
        $data['detail']   = $this->Laporan_model
            ->detail_penjualan_user($id_customer, $mode, $start, $end);

        $data['content'] = 'admin/laporan/detail_user';
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // EXPORT PDF
    // ==================================================
    public function export_pdf()
    {
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        $data['laporan'] = $this->Laporan_model
            ->laporan_penjualan_group_user($mode, $start, $end);

        require_once APPPATH.'third_party/dompdf/autoload.inc.php';

        $dompdf = new Dompdf();
        $html   = $this->load->view('admin/laporan/export_pdf', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan_penjualan.pdf', ['Attachment' => false]);
    }

    // ==================================================
    // EXPORT EXCEL
    // ==================================================
    public function export_excel()
    {
        $mode  = $this->input->get('mode') ?? '';
        $start = $this->input->get('start') ?? '';
        $end   = $this->input->get('end') ?? '';

        $laporan = $this->Laporan_model
            ->laporan_penjualan_group_user($mode, $start, $end);

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=laporan_penjualan.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, ['Customer','Total Transaksi','Total Belanja']);

        foreach ($laporan as $r) {
            fputcsv($output, [
                $r->nama_customer,
                $r->total_transaksi,
                $r->total_belanja
            ]);
        }

        fclose($output);
        exit;
    }
}
