<?php
/**
 * ==========================================================
 * DETAIL PESANAN - ZETTARIG (MISSION REPORT STYLE)
 * ==========================================================
 */

// Mapping Warna Status
$status_color = [
    'dibuat'              => 'warning',
    'menunggu_pembayaran' => 'warning',
    'menunggu_verifikasi' => 'info',
    'diproses'            => 'primary',
    'dikirim'             => 'secondary', // Di tema pixel, secondary sering dipakai untuk "ongoing"
    'selesai'             => 'success',
    'dibatalkan'          => 'danger'
];
$warna = $status_color[$pesanan->status_pesanan] ?? 'light';
?>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                    MISSION LOG #<?= $pesanan->id_penjualan; ?>
                </h5>
                <small class="text-secondary" style="font-family: 'VT323'; font-size: 1rem;">
                    Date: <?= date('d M Y H:i', strtotime($pesanan->tanggal_pesanan)); ?>
                </small>
            </div>
            
            <div class="px-3 py-2 border border-<?= $warna; ?> bg-<?= $warna; ?> bg-opacity-10 text-<?= $warna; ?> pixel-font" 
                 style="font-size: 0.8rem; box-shadow: 0 0 10px rgba(var(--bs-<?= $warna; ?>-rgb), 0.2);">
                STATUS: <?= strtoupper(str_replace('_', ' ', $pesanan->status_pesanan)); ?>
            </div>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">

        <div class="row g-4">

            <div class="col-lg-8">
                
                <div class="pixel-card bg-dark p-4 mb-4">
                    <h5 class="pixel-font text-white mb-4 border-bottom border-secondary pb-2">
                        <i class="fas fa-box-open me-2 text-primary"></i> ACQUIRED ITEMS
                    </h5>

                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($detail as $item): ?>
                            <div class="d-flex align-items-center border border-secondary p-2 bg-black">
                                <div class="bg-white p-1 me-3" style="width: 60px; height: 60px;">
                                    <?php if(!empty($item->gambar_produk)): ?>
                                        <img src="<?= base_url('assets/uploads/produk/'.$item->gambar_produk); ?>" 
                                             class="w-100 h-100 object-fit-cover">
                                    <?php else: ?>
                                        <div class="w-100 h-100 bg-secondary"></div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="text-white pixel-font mb-1" style="font-size: 0.8rem;">
                                        <?= htmlspecialchars($item->nama_produk); ?>
                                    </h6>
                                    <div class="text-secondary" style="font-family: 'VT323'; font-size: 1.1rem;">
                                        <?= $item->jumlah; ?> x Rp <?= number_format($item->harga_satuan, 0, ',', '.'); ?>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <span class="text-white fw-bold font-monospace">
                                        Rp <?= number_format($item->subtotal, 0, ',', '.'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                        <span class="pixel-font text-white">TOTAL VALUE</span>
                        <span class="text-warning display-6 fw-bold" style="font-family: 'VT323';">
                            Rp <?= number_format($pesanan->total_harga, 0, ',', '.'); ?>
                        </span>
                    </div>
                </div>

                <?php if (!empty($timeline)): ?>
                <div class="pixel-card bg-dark p-4">
                    <h5 class="pixel-font text-white mb-4 border-bottom border-secondary pb-2">
                        <i class="fas fa-history me-2 text-info"></i> MISSION HISTORY
                    </h5>
                    
                    <div class="position-relative ps-3 border-start border-secondary">
                        <?php foreach ($timeline as $log): ?>
                            <div class="mb-4 position-relative">
                                <div class="position-absolute top-0 start-0 translate-middle bg-<?= ($log->status_tahap == $pesanan->status_pesanan) ? 'success' : 'secondary'; ?> rounded-circle border border-dark" 
                                     style="width: 12px; height: 12px; left: -1px;"></div>
                                
                                <div class="ms-3">
                                    <span class="text-white pixel-font d-block" style="font-size: 0.7rem;">
                                        <?= strtoupper(str_replace('_', ' ', $log->status_tahap)); ?>
                                    </span>
                                    <small class="text-secondary font-monospace d-block">
                                        <?= date('d/m/Y H:i', strtotime($log->waktu)); ?>
                                    </small>
                                    <?php if(!empty($log->catatan)): ?>
                                        <div class="text-light mt-1 p-2 bg-secondary bg-opacity-25 border border-secondary" style="font-family: 'VT323'; font-size: 1.1rem;">
                                            > <?= $log->catatan; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <div class="col-lg-4">
                
                <div class="pixel-card bg-white p-4 sticky-top" style="top: 20px;">
                    <h5 class="pixel-font text-dark mb-4 border-bottom border-dark pb-2">
                        PAYMENT DATA
                    </h5>

                    <?php 
                        $last_log = !empty($timeline) ? end($timeline) : null;
                        if ($last_log && strpos(strtolower($last_log->status_tahap), 'ditolak') !== false): 
                    ?>
                        <div class="alert alert-danger rounded-0 border-2 border-danger mb-4">
                            <h6 class="pixel-font mb-1"><i class="fas fa-ban me-2"></i> REJECTED</h6>
                            <small style="font-family: 'VT323'; font-size: 1.1rem;">
                                Alasan: <?= $last_log->catatan; ?>
                            </small>
                        </div>
                    <?php endif; ?>

                    <?php if ($pesanan->metode_pembayaran === 'transfer'): ?>
                        
                        <div class="bg-dark p-3 mb-4 text-white">
                            <small class="text-secondary d-block mb-1">METODE:</small>
                            <span class="pixel-font text-warning">BANK TRANSFER</span>
                            
                            <hr class="border-secondary my-2">
                            
                            <small class="text-secondary d-block">REKENING TUJUAN:</small>
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="font-family: 'VT323'; font-size: 1.3rem;">BCA 1234567890</span>
                                <button class="btn btn-sm btn-outline-light py-0" onclick="navigator.clipboard.writeText('1234567890')">Copy</button>
                            </div>
                            <small class="d-block mt-1">a.n Zettarig Corp</small>
                        </div>

                        <?php if (in_array($pesanan->status_pesanan, ['dibuat', 'menunggu_pembayaran'])): ?>
                            
                            <form action="<?= base_url('pembayaran/process_upload'); ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_penjualan" value="<?= $pesanan->id_penjualan; ?>">
                                
                                <div class="mb-3">
                                    <label class="pixel-font text-dark mb-2" style="font-size: 0.7rem;">UPLOAD PROOF</label>
                                    <input type="file" name="bukti_bayar" class="form-control rounded-0 border-dark" required>
                                    <small class="text-muted" style="font-size: 0.7rem;">Format: JPG/PNG, Max 2MB</small>
                                </div>

                                <button type="submit" class="pixel-btn w-100 text-center py-2 bg-warning text-dark border-dark">
                                    <i class="fas fa-upload me-2"></i> SEND EVIDENCE
                                </button>
                            </form>

                        <?php elseif ($pesanan->status_pesanan === 'menunggu_verifikasi'): ?>
                            <div class="alert alert-info rounded-0 border-dark text-dark">
                                <i class="fas fa-hourglass-half me-2"></i> Bukti sedang diverifikasi admin.
                            </div>
                        <?php endif; ?>


                    <?php elseif ($pesanan->metode_pembayaran === 'cod'): ?>

    <div class="bg-dark p-3 mb-4 text-white">
        <small class="text-secondary d-block mb-1">METODE:</small>
        <span class="pixel-font text-info">C.O.D (CASH ON DELIVERY)</span>
        
        <?php if (isset($cod) && $cod->dp_wajib > 0): ?>
            <hr class="border-secondary my-2">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-secondary">Wajib DP (20%)</span>
                <span class="text-warning">Rp <?= number_format($cod->dp_wajib, 0, ',', '.'); ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-secondary">Sisa Bayar</span>
                <span class="text-white">Rp <?= number_format($cod->sisa_pembayaran, 0, ',', '.'); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <?php 
        // LOGIKA BARU: Cek apakah status Menunggu ATAU Ditolak
        // Agar form muncul kembali saat ditolak
        if (isset($cod) && in_array($cod->status_dp, ['menunggu', 'ditolak'])): 
    ?>
        
        <?php 
            // Cek log terakhir apakah ditolak (untuk flag tampilan)
            $is_rejected_log = ($last_log && strpos(strtolower($last_log->status_tahap), 'ditolak') !== false);
            // Form muncul jika: Status database 'ditolak' ATAU bukti belum ada ATAU ada log penolakan
            $show_form = ($cod->status_dp === 'ditolak' || empty($cod->bukti_dp) || $is_rejected_log);
        ?>

        <?php if ($show_form): ?>
            <form action="<?= base_url('pembayaran/process_dp'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_penjualan" value="<?= $pesanan->id_penjualan; ?>">
                
                <div class="mb-3">
                    <label class="pixel-font <?= $is_rejected_log ? 'text-danger' : 'text-dark'; ?> mb-2" style="font-size: 0.7rem;">
                        <?= $is_rejected_log ? 'RE-UPLOAD DP PROOF (REQUIRED)' : 'UPLOAD DP PROOF'; ?>
                    </label>
                    
                    <input type="file" name="bukti_dp" class="form-control rounded-0 <?= $is_rejected_log ? 'border-danger' : 'border-dark'; ?>" required>
                    
                    <?php if($is_rejected_log): ?>
                        <small class="text-danger d-block mt-1" style="font-family: 'VT323'; font-size: 1rem;">
                            * Bukti sebelumnya ditolak. Silakan unggah bukti baru yang valid.
                        </small>
                    <?php else: ?>
                        <small class="text-muted" style="font-size: 0.7rem;">Format: JPG/PNG, Max 2MB</small>
                    <?php endif; ?>
                </div>

                <button type="submit" class="pixel-btn w-100 text-center py-2 <?= $is_rejected_log ? 'bg-danger text-white' : 'bg-info text-dark'; ?> border-dark">
                    <i class="fas fa-upload me-2"></i> <?= $is_rejected_log ? 'RESEND EVIDENCE' : 'SEND DP PROOF'; ?>
                </button>
            </form>

        <?php else: ?>
            <div class="alert alert-info rounded-0 border-dark text-dark">
                <i class="fas fa-search me-2"></i> Bukti DP sedang dicek oleh admin.
            </div>
        <?php endif; ?>

    <?php elseif (isset($cod) && $cod->status_dp === 'diterima'): ?>
        
        <div class="alert alert-success rounded-0 border-dark text-dark">
            <i class="fas fa-check-circle me-2"></i> DP Lunas. Barang akan dikirim.
        </div>

    <?php endif; ?>

<?php endif; ?>

                    <hr class="border-dark my-4">

                    <a href="<?= base_url('akun/pesanan'); ?>" class="btn btn-outline-dark w-100 rounded-0 pixel-font" style="font-size: 0.7rem;">
                        < [ESC] BACK TO LIST
                    </a>

                </div>
            </div>

        </div>

    </div>
</section>