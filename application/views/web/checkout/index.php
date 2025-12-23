<?php
/**
 * ==========================================================
 * CHECKOUT PAGE - ZETTARIG (FIXED PAYMENT CARD VISIBILITY)
 * ==========================================================
 */
?>

<style>
    /* 1. INPUT FORM (Dark Theme) */
    .form-dark {
        background-color: #020617; /* Sangat gelap */
        border: 2px solid #333;
        color: #e5e7eb;
        font-family: 'VT323', monospace;
        font-size: 1.3rem;
    }
    .form-dark:focus {
        background-color: #000;
        color: #fff;
        border-color: var(--pixel-blue);
        outline: none;
    }
    .form-dark::placeholder {
        color: #4b5563;
    }

    /* 2. CUSTOM RADIO BUTTON (THEME FIX) */
    /* Sembunyikan radio asli */
    .payment-radio {
        display: none; 
    }

    /* Style Label sebagai Tombol */
    .pixel-option {
        display: block;
        width: 100%;
        padding: 20px;
        background-color: #0f172a; /* Warna Card */
        border: 2px solid #334155; /* Abu-abu biru */
        color: #94a3b8; /* Teks redup saat tidak dipilih */
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        height: 100%;
    }

    /* Efek Hover */
    .pixel-option:hover {
        border-color: var(--text-light);
        color: #fff;
    }

    /* 3. STATE CHECKED (SAAT DIPILIH) */
    .payment-radio:checked + .pixel-option {
        background-color: #000; /* Tetap gelap agar teks terbaca */
        border-color: var(--pixel-orange); /* Border Oranye */
        color: var(--pixel-orange); /* Teks Oranye */
        box-shadow: inset 0 0 15px rgba(251, 146, 60, 0.1);
    }

    /* Ubah warna Icon saat dipilih */
    .payment-radio:checked + .pixel-option i {
        color: var(--pixel-orange) !important;
    }

    /* Ubah warna teks kecil saat dipilih */
    .payment-radio:checked + .pixel-option small {
        color: #fdba74 !important; /* Oranye muda */
    }

    /* Indikator Centang Pojok */
    .check-indicator {
        display: none;
        position: absolute;
        top: 10px;
        right: 10px;
        color: var(--pixel-orange);
    }
    .payment-radio:checked + .pixel-option .check-indicator {
        display: block;
    }

    /* Sticky Summary */
    .sticky-summary {
        position: sticky;
        top: 20px;
    }
</style>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="me-3 text-success animate-blink">●</div>
            <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                FINAL STAGE: <span class="text-warning">CHECKOUT</span>
            </h5>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger rounded-0 border-2 border-dark mb-4 pixel-font fs-6">
                <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('checkout/process'); ?>" method="post">
            <div class="row g-5">

                <div class="col-lg-7">
                    
                    <div class="pixel-card bg-dark p-4 p-md-5 mb-4">
                        <div class="d-flex align-items-center mb-4 border-bottom border-secondary pb-3">
                            <i class="fas fa-map text-primary me-3 fa-2x"></i>
                            <div>
                                <h4 class="pixel-font text-white mb-1" style="font-size: 1rem;">SHIPPING COORDINATES</h4>
                                <small class="text-muted" style="font-family: 'VT323'; font-size: 1.1rem;">
                                    Lokasi pengiriman barang (Drop Point)
                                </small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-white pixel-font mb-2" style="font-size: 0.7rem;">RECIPIENT (PENERIMA)</label>
                            <input type="text" class="form-control form-dark" 
                                   value="<?= htmlspecialchars($this->session->userdata('customer_nama')); ?>" 
                                   readonly>
                        </div>

                        <div class="mb-4">
                            <label class="text-white pixel-font mb-2" style="font-size: 0.7rem;">FULL ADDRESS (ALAMAT LENGKAP)</label>
                            <textarea name="alamat" class="form-control form-dark" rows="4" required
                                      placeholder="Jln, No. Rumah, RT/RW, Kecamatan..."><?= htmlspecialchars($customer->alamat ?? ''); ?></textarea>
                        </div>

                    </div>

                    <div class="pixel-card bg-dark p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4 border-bottom border-secondary pb-3">
                            <i class="fas fa-credit-card text-warning me-3 fa-2x"></i>
                            <div>
                                <h4 class="pixel-font text-white mb-1" style="font-size: 1rem;">PAYMENT PROTOCOL</h4>
                                <small class="text-muted" style="font-family: 'VT323'; font-size: 1.1rem;">
                                    Pilih metode pembayaran
                                </small>
                            </div>
                        </div>

                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <input type="radio" class="payment-radio" name="metode_pembayaran" id="payTF" value="transfer" checked>
                                <label class="pixel-option" for="payTF">
                                    <i class="fas fa-check-circle check-indicator"></i>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-university fa-2x me-3 text-secondary"></i>
                                        <span class="pixel-font" style="font-size: 0.8rem;">BANK TRANSFER</span>
                                    </div>
                                    <small class="d-block" style="font-family: 'VT323'; font-size: 1.1rem;">
                                        > BCA / MANDIRI<br>> AUTO VERIFIKASI
                                    </small>
                                </label>
                            </div>

                            <div class="col-md-6">
    <input type="radio" class="payment-radio" name="metode_pembayaran" id="payCOD" value="cod">
    <label class="pixel-option" for="payCOD">
        <i class="fas fa-check-circle check-indicator"></i>
        <div class="d-flex align-items-center mb-2">
            <i class="fas fa-hand-holding-usd fa-2x me-3 text-secondary"></i>
            <span class="pixel-font" style="font-size: 0.8rem;">C.O.D (DP)</span>
        </div>
        
        <small class="d-block" style="font-family: 'VT323'; font-size: 1.1rem;">
            > BAYAR DITEMPAT<br>
            
            <?php 
                // LOGIKA: Tampilkan syarat DP hanya jika total > 5.000.000
                $threshold_cod = 5000000;
                if ($this->cart->total() > $threshold_cod): 
            ?>
                <span class="text-warning">> WAJIB DP ONGKIR (20%)</span>
            <?php else: ?>
                <span class="text-success">> TANPA DP</span>
            <?php endif; ?>
            
        </small>
    </label>
</div>

                        </div>
                    </div>

                </div>

                <div class="col-lg-5">
                    <div class="pixel-card bg-white p-4 sticky-summary text-dark">
                        
                        <h5 class="pixel-font text-dark border-bottom border-dark pb-3 mb-3 text-center">
                            ORDER MANIFEST
                        </h5>

                        <div class="d-flex flex-column gap-3 mb-4 pe-2" style="max-height: 400px; overflow-y: auto;">
                            <?php foreach ($this->cart->contents() as $item): ?>
                                <div class="d-flex align-items-start border-bottom border-secondary pb-2">
                                    <div class="bg-dark text-white px-2 py-1 me-2 pixel-font" style="font-size: 0.7rem;">
                                        x<?= $item['qty']; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-dark fw-bold" style="font-family: 'VT323'; font-size: 1.2rem; line-height: 1.1;">
                                            <?= htmlspecialchars($item['name']); ?>
                                        </div>
                                    </div>
                                    <div class="text-dark font-monospace fw-bold" style="font-size: 0.9rem;">
                                        <?= number_format($item['subtotal'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="bg-dark p-3 mb-4 border border-secondary">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="pixel-font text-white" style="font-size: 0.8rem;">TOTAL</span>
                                <span class="text-warning fw-bold display-6" style="font-family: 'VT323';">
                                    Rp <?= number_format($this->cart->total(), 0, ',', '.'); ?>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="pixel-btn w-100 text-center py-3 bg-primary text-white border-dark" 
                                onclick="return confirm('Konfirmasi dan proses pesanan ini?')">
                            <i class="fas fa-check-square me-2"></i> CONFIRM ORDER
                        </button>
                        
                        <a href="<?= base_url('cart'); ?>" class="btn btn-outline-dark w-100 mt-3 rounded-0 pixel-font" style="font-size: 0.6rem;">
                            < [ESC] EDIT INVENTORY
                        </a>

                    </div>
                </div>

            </div>
        </form>

    </div>
</section>