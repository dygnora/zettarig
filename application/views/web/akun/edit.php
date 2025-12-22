<?php
/**
 * ==========================================================
 * EDIT PROFILE - ZETTARIG (CHARACTER CREATION STYLE)
 * ==========================================================
 */

// Siapkan URL Foto
$foto = (!empty($customer->foto_profil) && file_exists(FCPATH.'assets/uploads/profil/'.$customer->foto_profil))
    ? base_url('assets/uploads/profil/'.$customer->foto_profil)
    : 'https://api.dicebear.com/9.x/pixel-art/svg?seed=' . urlencode($customer->nama);
?>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center">
            <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                <span class="text-secondary">root@zettarig:~/users/</span><span class="text-warning">customize_character.exe</span>
            </h5>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">
        
        <form action="<?= base_url('akun/edit'); ?>" method="post" enctype="multipart/form-data">
        
        <div class="row g-5 justify-content-center">

            <div class="col-md-4">
                <div class="pixel-card bg-dark p-4 text-center sticky-top" style="top: 100px; z-index: 1;">
                    
                    <h5 class="pixel-font text-white mb-4">AVATAR PREVIEW</h5>

                    <div class="position-relative d-inline-block mb-4">
                        <div class="bg-white p-1 border border-4 border-secondary" style="width: 200px; height: 200px;">
                            <img id="imgPreview" src="<?= $foto; ?>" alt="Preview" class="w-100 h-100 object-fit-cover">
                        </div>
                        
                        <div class="position-absolute top-0 start-0 border-top border-start border-warning border-4 w-25 h-25" style="transform: translate(-10px, -10px);"></div>
                        <div class="position-absolute bottom-0 end-0 border-bottom border-end border-warning border-4 w-25 h-25" style="transform: translate(10px, 10px);"></div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" onclick="document.getElementById('uploadInput').click()" 
                                class="pixel-btn bg-warning text-dark border-light w-100">
                            <i class="fas fa-camera me-2"></i> PILIH FOTO
                        </button>
                        <small class="text-secondary" style="font-family: 'VT323'; font-size: 1rem;">
                            Format: JPG/PNG, Max: 2MB
                        </small>
                    </div>

                    <input type="file" name="foto_profil" id="uploadInput" class="d-none" accept="image/*">

                </div>
            </div>

            <div class="col-md-7 col-lg-6">

                <div class="pixel-card bg-dark p-4 p-md-5">
                    
                    <div class="mb-4 border-bottom border-secondary pb-3">
                        <h2 class="pixel-font text-white">UPDATE STATS</h2>
                        <p class="text-secondary" style="font-family: 'VT323'; font-size: 1.2rem;">
                            Sesuaikan data karakter Anda
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="text-info pixel-font mb-2" style="font-size: 0.7rem;">CHARACTER NAME</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary text-dark border-secondary rounded-0"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" 
                                   class="form-control bg-black text-white border-secondary" 
                                   style="font-family: 'VT323'; font-size: 1.4rem;"
                                   value="<?= set_value('nama', $customer->nama); ?>">
                        </div>
                        <?= form_error('nama', '<small class="text-danger pixel-font mt-1 d-block" style="font-size:0.6rem;">', '</small>'); ?>
                    </div>

                    <div class="mb-4">
                        <label class="text-info pixel-font mb-2" style="font-size: 0.7rem;">COMMUNICATION (HP)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary text-dark border-secondary rounded-0"><i class="fas fa-phone"></i></span>
                            <input type="text" name="no_hp" 
                                   class="form-control bg-black text-white border-secondary" 
                                   style="font-family: 'VT323'; font-size: 1.4rem;"
                                   value="<?= set_value('no_hp', $customer->no_hp); ?>">
                        </div>
                        <?= form_error('no_hp', '<small class="text-danger pixel-font mt-1 d-block" style="font-size:0.6rem;">', '</small>'); ?>
                    </div>

                    <div class="mb-4">
                        <label class="text-info pixel-font mb-2" style="font-size: 0.7rem;">BASE LOCATION (ALAMAT)</label>
                        <textarea name="alamat" rows="3" 
                                  class="form-control bg-black text-white border-secondary" 
                                  style="font-family: 'VT323'; font-size: 1.3rem;"><?= set_value('alamat', $customer->alamat); ?></textarea>
                        <?= form_error('alamat', '<small class="text-danger pixel-font mt-1 d-block" style="font-size:0.6rem;">', '</small>'); ?>
                    </div>

                    <div class="mt-5 pt-4 border-top border-secondary position-relative">
                        <span class="position-absolute top-0 start-50 translate-middle badge bg-dark border border-secondary text-secondary pixel-font">SECURITY</span>
                        
                        <div class="mb-3">
                            <label class="text-warning pixel-font mb-2" style="font-size: 0.7rem;">NEW PASSWORD</label>
                            <input type="password" name="password" 
                                   class="form-control bg-black text-white border-secondary" 
                                   placeholder="************"
                                   style="font-family: 'VT323'; font-size: 1.3rem;">
                            <small class="text-secondary" style="font-family: 'VT323'; font-size: 1rem;">
                                * Biarkan kosong jika tidak ingin mengubah password.
                            </small>
                        </div>
                    </div>

                    <div class="d-grid gap-3 mt-5">
                        <button type="submit" class="pixel-btn w-100 py-3 text-center">
                            <i class="fas fa-save me-2"></i> SIMPAN & UPDATE
                        </button>
                        
                        <a href="<?= base_url('akun'); ?>" class="btn btn-outline-danger rounded-0 py-2 border-secondary" style="font-family: 'Press Start 2P'; font-size: 0.7rem;">
                            <i class="fas fa-times me-2"></i> BATAL
                        </a>
                    </div>

                </div>

            </div>
        </div>
        
        </form>
        </div>
</section>

<script>
    document.getElementById('uploadInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>