<?php
/**
 * ==========================================================
 * DASHBOARD CUSTOMER - ZETTARIG (RPG PROFILE STYLE)
 * ==========================================================
 */

// 1. Cek Path File Fisik & Cache Buster
$file_path = FCPATH . 'assets/uploads/profil/' . $customer->foto_profil;
$base_foto = (!empty($customer->foto_profil) && file_exists($file_path))
    ? base_url('assets/uploads/profil/' . $customer->foto_profil)
    : 'https://api.dicebear.com/9.x/pixel-art/svg?seed=' . urlencode($customer->nama);

// Tambahkan parameter waktu agar browser selalu memuat gambar baru
$foto = $base_foto . '?v=' . time(); 
?>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="me-3 text-success animate-blink">●</div>
            <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                PLAYER ONE: <span class="text-warning"><?= strtoupper($customer->nama); ?></span>
            </h5>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success rounded-0 border-2 border-dark mb-4 pixel-font fs-6">
                <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger rounded-0 border-2 border-dark mb-4 pixel-font fs-6">
                <i class="fas fa-times-circle me-2"></i> <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="pixel-card bg-dark p-4 text-center h-100">
                    
                    <div class="badge bg-primary pixel-font rounded-0 border border-light mb-4">AVATAR</div>

                    <div class="position-relative mb-3 mx-auto" style="width: 100%; max-width: 200px;">
                        
                        <div class="bg-white p-1 border border-4 border-secondary ratio ratio-1x1">
                            <img src="<?= $foto; ?>" alt="Profile" class="w-100 h-100 object-fit-cover">
                        </div>
                        
                        <button onclick="document.getElementById('fileInput').click()" 
                                class="btn btn-warning btn-sm border border-dark position-absolute bottom-0 end-0 rounded-0" 
                                title="Ganti Foto"
                                style="transform: translate(20%, 20%); box-shadow: 2px 2px 0 #000; z-index: 10;">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <form id="formUpload" action="<?= base_url('akun/upload_foto'); ?>" method="post" enctype="multipart/form-data">
                        <input type="file" name="foto_profil" id="fileInput" class="d-none" accept="image/*" onchange="document.getElementById('formUpload').submit();">
                    </form>

                    <h5 class="text-white pixel-font mt-3"><?= htmlspecialchars($customer->nama); ?></h5>
                    <p class="text-secondary" style="font-family: 'VT323'; font-size: 1.2rem;">
                        Member Zettarig
                    </p>

                    <div class="row mt-4 border-top border-secondary pt-3">
                        <div class="col-6 border-end border-secondary">
                            <small class="text-white-50 d-block pixel-font mb-1" style="font-size: 0.7rem;">JOINED</small>
                            <span class="text-info" style="font-family: 'VT323'; font-size: 1.2rem;">
                                <?= date('M Y', strtotime($customer->created_at ?? date('Y-m-d'))); ?>
                            </span>
                        </div>
                        <div class="col-6">
                            <small class="text-white-50 d-block pixel-font mb-1" style="font-size: 0.7rem;">STATUS</small>
                            <span class="text-success" style="font-family: 'VT323'; font-size: 1.2rem;">ACTIVE</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-8">
                
                <div class="pixel-card bg-dark p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                        <h5 class="text-white pixel-font mb-0" style="font-size: 0.9rem;">
                            <i class="fas fa-terminal me-2 text-primary"></i> PLAYER STATS
                        </h5>
                        <a href="<?= base_url('akun/edit'); ?>" class="btn btn-sm btn-outline-light rounded-0" style="font-size: 0.7rem;">
                            <i class="fas fa-edit"></i> EDIT
                        </a>
                    </div>

                    <div class="row g-3" style="font-family: 'VT323'; font-size: 1.4rem;">
                        <div class="col-md-6">
                            <label class="text-secondary d-block" style="font-size: 1rem;">EMAIL ADDRESS</label>
                            <div class="text-white border border-secondary p-2 bg-black text-truncate">
                                <?= htmlspecialchars($customer->email); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary d-block" style="font-size: 1rem;">PHONE NUMBER</label>
                            <div class="text-white border border-secondary p-2 bg-black">
                                <?= htmlspecialchars($customer->no_hp); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="text-secondary d-block" style="font-size: 1rem;">SHIPPING ADDRESS</label>
                            <div class="text-white border border-secondary p-2 bg-black">
                                <?= !empty($customer->alamat) ? nl2br(htmlspecialchars($customer->alamat)) : '<span class="text-muted opacity-50">Belum diatur</span>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pixel-card bg-white p-4">
                    <h5 class="pixel-font text-dark mb-3" style="font-size: 0.9rem;">MAIN MENU</h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="<?= base_url('akun/pesanan'); ?>" class="pixel-btn bg-primary text-white w-100 text-center py-3 text-decoration-none">
                                <i class="fas fa-scroll me-2"></i> RIWAYAT PESANAN
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('cart'); ?>" class="pixel-btn bg-warning text-dark w-100 text-center py-3 text-decoration-none">
                                <i class="fas fa-shopping-cart me-2"></i> CEK KERANJANG
                            </a>
                        </div>
                        <div class="col-12 mt-4">
                            <a href="<?= base_url('auth/logout'); ?>" 
                               class="btn btn-danger w-100 rounded-0 py-2 border border-dark shadow-sm"
                               onclick="return confirm('Apakah Anda yakin ingin logout?');"
                               style="font-family: 'Press Start 2P'; font-size: 0.7rem;">
                                <i class="fas fa-power-off me-2"></i> LOG OUT GAME
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
    @keyframes blink { 50% { opacity: 0; } }
    .animate-blink { animation: blink 1s step-start infinite; }
    
    /* Tambahan agar gambar responsive sempurna */
    .ratio-1x1 {
        aspect-ratio: 1/1;
    }
</style>