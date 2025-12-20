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
        <div class="card card-primary card-outline mb-3">
            <div class="card-header">
                <h3 class="card-title">Aksi Admin</h3>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2">
                    
                    <?php if (in_array($penjualan->status_pesanan, ['dibuat', 'menunggu_verifikasi', 'menunggu_pembayaran'])): ?>
                        <a href="<?= base_url('admin/penjualan/proses/'.$penjualan->id_penjualan); ?>" 
                           class="btn btn-primary mr-2"
                           onclick="return confirm('Verifikasi dan Proses pesanan ini?');">
                           <i class="fas fa-check"></i> Proses Pesanan
                        </a>
                    <?php endif; ?>

                    <?php if ($penjualan->status_pesanan == 'diproses'): ?>
                        <a href="<?= base_url('admin/penjualan/kirim/'.$penjualan->id_penjualan); ?>" 
                           class="btn btn-info mr-2"
                           onclick="return confirm('Ubah status jadi DIKIRIM?');">
                           <i class="fas fa-truck"></i> Kirim Barang
                        </a>
                    <?php endif; ?>

                    <?php if ($penjualan->status_pesanan == 'dikirim'): ?>
                        <a href="<?= base_url('admin/penjualan/selesai/'.$penjualan->id_penjualan); ?>" 
                           class="btn btn-success mr-2"
                           onclick="return confirm('Selesaikan pesanan ini?');">
                           <i class="fas fa-check-double"></i> Pesanan Selesai
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url('admin/penjualan/batal/'.$penjualan->id_penjualan); ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Yakin BATALKAN pesanan ini?');">
                       <i class="fas fa-times"></i> Batalkan
                    </a>

                </div>
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
                                    $bg = 'bg-gray'; // Default

                                    // 1. Dibuat (Biru Tua)
                                    if(strpos($tahap, 'dibuat') !== false) {
                                        $bg = 'bg-primary';
                                    } 
                                    // 2. Upload Bukti
                                    // - Kuning jika pesanan sudah diproses (diterima)
                                    // - Abu-abu jika belum
                                    elseif(strpos($tahap, 'upload') !== false) {
                                        if (in_array($penjualan->status_pesanan, ['diproses', 'dikirim', 'selesai'])) {
                                            $bg = 'bg-warning'; 
                                        } else {
                                            $bg = 'bg-gray';
                                        }
                                    }
                                    // 3. Pembayaran Diterima (HIJAU)
                                    elseif(strpos($tahap, 'diterima') !== false) {
                                        $bg = 'bg-success';
                                    }
                                    // 4. Diproses (Biru Muda)
                                    elseif(strpos($tahap, 'diproses') !== false) {
                                        $bg = 'bg-info';
                                    }
                                    // 5. Dikirim (Ungu)
                                    elseif(strpos($tahap, 'dikirim') !== false) {
                                        $bg = 'bg-purple';
                                    }
                                    // 6. Selesai (Hijau)
                                    elseif(strpos($tahap, 'selesai') !== false) {
                                        $bg = 'bg-success';
                                    }
                                    // 7. Dibatalkan / Ditolak (Merah)
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