<?php
/**
 * ==========================================================
 * EDIT PROFILE - ZETTARIG (TOP SECRET DOSSIER STYLE)
 * ==========================================================
 */
?>

<style>
    /* Efek Kertas/Dokumen Digital */
    .dossier-card {
        background-color: #0f172a;
        border: 4px solid #334155;
        position: relative;
        overflow: hidden;
        box-shadow: 15px 15px 0 rgba(0,0,0,0.5);
    }
    
    /* Stempel Confidential */
    .stamp-confidential {
        position: absolute;
        top: 20px;
        right: -20px;
        color: rgba(255, 255, 255, 0.03);
        font-family: 'Press Start 2P', cursive;
        font-size: 3rem;
        transform: rotate(-15deg);
        pointer-events: none;
        z-index: 0;
        border: 5px solid rgba(255, 255, 255, 0.03);
        padding: 10px 20px;
    }

    /* Input Field ala Data Entry */
    .input-dossier {
        background: transparent;
        border: none;
        border-bottom: 2px dashed #475569;
        color: #fff;
        font-family: 'VT323', monospace;
        font-size: 1.5rem;
        padding: 5px 0;
        border-radius: 0;
    }
    .input-dossier:focus {
        background: rgba(255,255,255,0.05);
        color: #fb923c; /* Pixel Orange */
        border-bottom: 2px solid #fb923c;
        box-shadow: none;
        outline: none;
    }
    .input-label {
        font-family: 'Press Start 2P';
        font-size: 0.6rem;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }
</style>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                <i class="fas fa-folder-open me-2 text-warning"></i> ACCESSING RECORD: <span class="text-info"><?= $customer->id_customer; ?></span>
            </h5>
            <span class="badge bg-danger rounded-0 pixel-font">LEVEL 1 CLEARANCE</span>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-7">
                
                <form action="<?= base_url('akun/edit'); ?>" method="post">
                
                    <div class="dossier-card p-5">
                        
                        <div class="stamp-confidential">CONFIDENTIAL</div>

                        <div class="row align-items-end border-bottom border-secondary pb-4 mb-5 position-relative" style="z-index: 1;">
                            <div class="col-8">
                                <h2 class="pixel-font text-white mb-1">PERSONNEL FILE</h2>
                                <p class="text-secondary mb-0 pixel-font" style="font-size: 0.6rem;">ZETTARIG DATABASE // VER 2.0</p>
                            </div>
                            <div class="col-4 text-end">
                                <i class="fas fa-barcode fa-4x text-secondary opacity-50"></i>
                            </div>
                        </div>

                        <div class="mb-4 position-relative" style="z-index: 1;">
                            <label class="input-label">CODENAME (NAMA LENGKAP)</label>
                            <input type="text" name="nama" 
                                   class="form-control input-dossier" 
                                   value="<?= set_value('nama', $customer->nama); ?>" required>
                            <?= form_error('nama', '<small class="text-danger pixel-font mt-1 d-block" style="font-size:0.5rem;">', '</small>'); ?>
                        </div>

                        <div class="mb-4 position-relative" style="z-index: 1;">
                            <label class="input-label">SECURE LINE (NO HP)</label>
                            <input type="text" name="no_hp" 
                                   class="form-control input-dossier" 
                                   value="<?= set_value('no_hp', $customer->no_hp); ?>" required>
                            <?= form_error('no_hp', '<small class="text-danger pixel-font mt-1 d-block" style="font-size:0.5rem;">', '</small>'); ?>
                        </div>

                        <div class="mb-5 position-relative" style="z-index: 1;">
                            <label class="input-label">BASE OF OPERATIONS (ALAMAT)</label>
                            <textarea name="alamat" rows="2" 
                                      class="form-control input-dossier" required><?= set_value('alamat', $customer->alamat); ?></textarea>
                            <?= form_error('alamat', '<small class="text-danger pixel-font mt-1 d-block" style="font-size:0.5rem;">', '</small>'); ?>
                        </div>

                        <div class="bg-black p-3 border border-secondary mb-5 position-relative" style="z-index: 1;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="text-warning pixel-font mb-0" style="font-size: 0.7rem;">
                                    <i class="fas fa-key me-2"></i> CHANGE YOUR PASSWORD
                                </label>
                                <span class="text-secondary pixel-font" style="font-size: 0.5rem;">OPTIONAL</span>
                            </div>
                            <input type="password" name="password" 
                                   class="form-control input-dossier text-warning" 
                                   placeholder="LEAVE EMPTY TO KEEP CURRENT" 
                                   style="font-size: 1.2rem; border-bottom-color: #333;">
                        </div>

                        <div class="row g-0">
                            <div class="col-8">
                                <button type="submit" class="pixel-btn w-100 py-3 text-center border-0 bg-warning text-dark h-100">
                                    UPDATE RECORDS
                                </button>
                            </div>
                            <div class="col-4 border-start border-dark">
                                <a href="<?= base_url('akun'); ?>" class="btn btn-dark w-100 h-100 rounded-0 d-flex align-items-center justify-content-center pixel-font text-decoration-none text-secondary" style="font-size: 0.7rem;">
                                    CLOSE FILE
                                </a>
                            </div>
                        </div>

                    </div>
                
                </form>

            </div>
        </div>

    </div>
</section>