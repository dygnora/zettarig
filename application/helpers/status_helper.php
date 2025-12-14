<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('badge_status_pesanan')) {

    /**
     * Badge status pesanan (AdminLTE compatible)
     *
     * @param string $status
     * @return string HTML badge
     */
    function badge_status_pesanan($status)
    {
        switch (strtolower($status)) {

            case 'baru':
                return '<span class="badge bg-primary">Baru</span>';

            case 'menunggu_verifikasi':
                return '<span class="badge bg-warning">Menunggu Verifikasi</span>';

            case 'diproses':
                return '<span class="badge bg-info">Diproses</span>';

            case 'dikirim':
                return '<span class="badge bg-secondary">Dikirim</span>';

            case 'selesai':
                return '<span class="badge bg-success">Selesai</span>';

            case 'dibatalkan':
                return '<span class="badge bg-danger">Dibatalkan</span>';

            default:
                return '<span class="badge bg-dark">Unknown</span>';
        }
    }
}
