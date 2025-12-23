<?php
/**
 * ==========================================================
 * RIWAYAT PESANAN - ZETTARIG (TERMINAL LOG STYLE)
 * ==========================================================
 */
?>

<style>
    /* Pagination Kotak Hitam */
    .page-link {
        background-color: #000 !important;
        border: 1px solid #333 !important;
        color: var(--pixel-blue) !important;
        font-family: 'Press Start 2P', monospace;
        font-size: 0.6rem;
        margin: 0 2px;
        padding: 10px 15px;
    }
    .page-item.active .page-link {
        background-color: var(--pixel-orange) !important;
        border-color: var(--pixel-orange) !important;
        color: #000 !important;
    }
    .page-link:hover {
        background-color: #333 !important;
    }
    /* Hover Baris Tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(255,255,255,0.05);
    }
</style>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                    <i class="fas fa-list-alt me-2 text-warning"></i> TRANSACTION LOGS
                </h5>
                <small class="text-secondary" style="font-family: 'VT323'; font-size: 1rem;">
                    User: <?= $this->session->userdata('customer_nama'); ?>
                </small>
            </div>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="pixel-card bg-dark p-0 overflow-hidden" style="min-height: 400px; border-color: #333;">
                    
                    <?php if (!empty($pesanan)): ?>

                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0" style="border-color: #333;">
                                <thead class="bg-black text-secondary">
                                    <tr class="pixel-font" style="font-size: 0.7rem;">
                                        <th class="p-3">MISSION ID</th>
                                        <th class="p-3">DATE / TIME</th>
                                        <th class="p-3">PAYMENT</th>
                                        <th class="p-3 text-center">STATUS</th>
                                        <th class="p-3 text-end">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($pesanan as $p): ?>
                                        <tr style="font-family: 'VT323'; font-size: 1.2rem;">
                                            <td class="p-3">
                                                <span class="text-info fw-bold">#<?= $p->id_penjualan; ?></span>
                                            </td>

                                            <td class="p-3">
                                                <div class="d-flex flex-column">
                                                    <span class="text-white"><?= date('d M Y', strtotime($p->tanggal_pesanan)); ?></span>
                                                    <small class="text-muted" style="font-size: 0.9rem;">
                                                        <?= date('H:i', strtotime($p->tanggal_pesanan)); ?> WIB
                                                    </small>
                                                </div>
                                            </td>

                                            <td class="p-3">
                                                <span class="text-warning fw-bold">
                                                    Rp <?= number_format($p->total_harga, 0, ',', '.'); ?>
                                                </span>
                                                <br>
                                                <small class="text-muted text-uppercase" style="font-size: 0.9rem;">
                                                    [<?= $p->metode_pembayaran; ?>]
                                                </small>
                                            </td>

                                            <td class="p-3 text-center">
                                                <?php
                                                    $status_class = 'secondary';
                                                    $status_label = $p->status_pesanan;

                                                    // Logic Warna Status
                                                    switch ($p->status_pesanan) {
                                                        case 'dibuat': 
                                                        case 'menunggu_pembayaran': 
                                                            $status_class = 'warning text-dark'; $status_label = 'UNPAID'; break;
                                                        case 'menunggu_verifikasi': 
                                                            $status_class = 'info text-dark'; $status_label = 'VERIFYING'; break;
                                                        case 'diproses': 
                                                            $status_class = 'primary'; $status_label = 'PROCESSING'; break;
                                                        case 'dikirim': 
                                                            $status_class = 'light text-dark'; $status_label = 'SHIPPING'; break;
                                                        case 'selesai': 
                                                            $status_class = 'success'; $status_label = 'COMPLETED'; break;
                                                        case 'dibatalkan': 
                                                            $status_class = 'danger'; $status_label = 'FAILED'; break;
                                                    }
                                                ?>
                                                <span class="badge bg-<?= $status_class; ?> rounded-0 pixel-font" style="font-size: 0.6rem;">
                                                    <?= strtoupper($status_label); ?>
                                                </span>
                                            </td>

                                            <td class="p-3 text-end">
                                                <a href="<?= base_url('akun/pesanan/detail/'.$p->id_penjualan); ?>" 
                                                   class="btn btn-sm btn-outline-light rounded-0 pixel-font"
                                                   style="font-size: 0.6rem;">
                                                   OPEN LOG <i class="fas fa-caret-right ms-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                    <?php else: ?>

                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-4x text-secondary mb-3 opacity-25"></i>
                            <h4 class="pixel-font text-white">NO LOGS FOUND</h4>
                            <p class="text-secondary" style="font-family: 'VT323'; font-size: 1.2rem;">
                                Belum ada riwayat transaksi yang tercatat di sistem.
                            </p>
                            <a href="<?= base_url('produk'); ?>" class="pixel-btn bg-warning text-dark mt-3">
                                START NEW MISSION
                            </a>
                        </div>

                    <?php endif; ?>

                </div>

                <div class="mt-4">
                    <?= $pagination; ?>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="<?= base_url('akun'); ?>" class="text-muted text-decoration-none pixel-font" style="font-size: 0.7rem;">
                        < [ESC] RETURN TO DASHBOARD
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>