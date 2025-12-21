<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Penjualan #<?= $penjualan->id_penjualan; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/penjualan'); ?>">Penjualan</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if (!in_array($penjualan->status_pesanan, ['selesai', 'dibatalkan'])): ?>
        <div class="card card-outline card-primary mb-3">
            <div class="card-header">
                <h3 class="card-title">Aksi Admin</h3>
            </div>
            <div class="card-body">

                <?php if (in_array($penjualan->status_pesanan, ['dibuat', 'menunggu_pembayaran', 'menunggu_verifikasi'])): ?>
                    
                    <?php 
                    // LOGIKA BARU: Cek apakah COD Kecil (< 5 Juta)
                    // Aturan: Jika COD dan < 5jt, tidak perlu DP, bisa langsung proses.
                    $is_cod_kecil = ($penjualan->metode_pembayaran == 'cod' && $penjualan->total_harga < 5000000);
                    ?>

                    <?php if ($is_cod_kecil): ?>
                        
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle"></i> Pesanan COD (Tanpa DP)</h5>
                            <p class="mb-2">
                                Total belanja dibawah Rp 5.000.000. <strong>Tidak memerlukan DP.</strong><br>
                                Silakan langsung proses (packing) pesanan ini.
                            </p>
                            
                            <div class="d-flex mt-3">
                                <a href="<?= base_url('admin/penjualan/proses/'.$penjualan->id_penjualan); ?>" 
                                   class="btn btn-primary mr-2"
                                   onclick="return confirm('Verifikasi dan Proses pesanan ini?');">
                                   <i class="fas fa-box-open"></i> PROSES PESANAN
                                </a>

                                <a href="<?= base_url('admin/penjualan/batal/'.$penjualan->id_penjualan); ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                   <i class="fas fa-times"></i> Batalkan
                                </a>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Pembayaran Belum Valid!</h5>
                            <p class="mb-2">
                                Anda tidak dapat memproses pesanan ini karena pembayaran/DP belum diverifikasi.<br>
                                Silakan cek bukti pembayaran terlebih dahulu.
                            </p>
                            
                            <div class="d-flex mt-3">
                                <?php if ($penjualan->metode_pembayaran == 'cod'): ?>
                                    <a href="<?= base_url('admin/cod/penjualan/'.$penjualan->id_penjualan); ?>" class="btn btn-outline-dark mr-2">
                                        <i class="fas fa-hand-holding-usd mr-1"></i> Cek & Verifikasi DP COD
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('admin/pembayaran/penjualan/'.$penjualan->id_penjualan); ?>" class="btn btn-outline-dark mr-2">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Cek Bukti Transfer
                                    </a>
                                <?php endif; ?>
                                
                                <a href="<?= base_url('admin/penjualan/batal/'.$penjualan->id_penjualan); ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                   <i class="fas fa-times"></i> Batalkan Pesanan
                                </a>
                            </div>
                        </div>

                    <?php endif; ?>

                <?php elseif ($penjualan->status_pesanan == 'diproses'): ?>
                    
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Pembayaran telah diverifikasi. Pesanan siap dikirim.
                    </div>

                    <a href="<?= base_url('admin/penjualan/kirim/'.$penjualan->id_penjualan); ?>" 
                       class="btn btn-primary btn-lg mr-2"
                       onclick="return confirm('Pesanan sudah dipacking dan siap dikirim?');">
                       <i class="fas fa-truck"></i> KIRIM BARANG
                    </a>
                    
                    <a href="<?= base_url('admin/penjualan/batal/'.$penjualan->id_penjualan); ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Yakin ingin membatalkan pesanan ini?');">
                       <i class="fas fa-times"></i> Batalkan
                    </a>

                <?php elseif ($penjualan->status_pesanan == 'dikirim'): ?>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-truck"></i> Pesanan sedang dalam pengiriman.
                    </div>
                    
                    <?php if ($penjualan->metode_pembayaran == 'cod'): ?>
                        
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-hand-holding-usd"></i> Menunggu Pelunasan COD</h5>
                            <p class="mb-2">
                                Pesanan ini menggunakan metode <strong>COD</strong>.<br>
                                Anda tidak bisa menandai selesai secara manual di sini.<br>
                                Silakan input pelunasan uang COD terlebih dahulu.
                            </p>
                            <a href="<?= base_url('admin/cod/penjualan/'.$penjualan->id_penjualan); ?>" 
                               class="btn btn-warning text-bold">
                               <i class="fas fa-money-bill-wave"></i> INPUT PELUNASAN COD
                            </a>
                        </div>

                    <?php else: ?>

                        <a href="<?= base_url('admin/penjualan/selesai/'.$penjualan->id_penjualan); ?>" 
                           class="btn btn-success btn-lg"
                           onclick="return confirm('Pastikan barang sudah diterima customer. Selesaikan pesanan?');">
                           <i class="fas fa-check-double"></i> TANDAI SELESAI
                        </a>

                    <?php endif; ?>

                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>


        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-dark">
                        <h3 class="card-title">Item Pesanan</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($detail as $d): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($d->nama_produk); ?></td>
                                    <td><?= $d->jumlah; ?></td>
                                    <td>Rp <?= number_format($d->harga_satuan, 0, ',', '.'); ?></td>
                                    <td>Rp <?= number_format($d->subtotal, 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th>Rp <?= number_format($penjualan->total_harga, 0, ',', '.'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Timeline History</h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <?php foreach ($timeline as $t): ?>
                            <div>
                                <?php 
                                    $tahap = strtolower($t->status_tahap);
                                    $bg = 'bg-gray'; // Default (Abu-abu)

                                    if(strpos($tahap, 'dibuat') !== false) {
                                        $bg = 'bg-primary';
                                    } 
                                    elseif(strpos($tahap, 'upload') !== false) {
                                        if (in_array($penjualan->status_pesanan, ['diproses', 'dikirim', 'selesai'])) {
                                            $bg = 'bg-warning'; 
                                        } else {
                                            $bg = 'bg-gray';
                                        }
                                    }
                                    elseif(strpos($tahap, 'diterima') !== false || strpos($tahap, 'lunas') !== false) {
                                        $bg = 'bg-success';
                                    }
                                    elseif(strpos($tahap, 'diproses') !== false) {
                                        $bg = 'bg-info';
                                    }
                                    elseif(strpos($tahap, 'dikirim') !== false) {
                                        $bg = 'bg-purple';
                                    }
                                    elseif(strpos($tahap, 'selesai') !== false) {
                                        $bg = 'bg-success';
                                    }
                                    elseif(strpos($tahap, 'dibatalkan') !== false || strpos($tahap, 'ditolak') !== false) {
                                        $bg = 'bg-danger';
                                    }
                                ?>
                                
                                <i class="fas fa-circle <?= $bg; ?>"></i>
                                
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> <?= date('d M H:i', strtotime($t->waktu)); ?></span>
                                    <h3 class="timeline-header no-border">
                                        <strong><?= $t->status_tahap; ?></strong>
                                    </h3>
                                    <?php if ($t->catatan): ?>
                                    <div class="timeline-body">
                                        <?= htmlspecialchars($t->catatan); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Info Customer</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-user mr-1"></i> Nama</strong>
                        <p class="text-muted"><?= htmlspecialchars($penjualan->nama_customer); ?></p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Kirim</strong>
                        <p class="text-muted"><?= nl2br(htmlspecialchars($penjualan->alamat_pengiriman)); ?></p>
                        <hr>
                        <strong>Status Saat Ini:</strong><br>
                        <span class="badge badge-lg badge-info" style="font-size: 1rem;">
                            <?= strtoupper(str_replace('_', ' ', $penjualan->status_pesanan)); ?>
                        </span>
                    </div>
                </div>

                <a href="<?= base_url('admin/penjualan'); ?>" class="btn btn-default btn-block">
                    <i class="fas fa-arrow-left"></i> Kembali ke List
                </a>
            </div>
        </div>
    </div>
</section>