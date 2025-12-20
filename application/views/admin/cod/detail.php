<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detail COD #<?= $cod->id_cod; ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('admin/cod'); ?>">COD</a></li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
        
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Rincian Tagihan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Customer</th>
                            <td>: <?= htmlspecialchars($cod->nama_customer); ?> (<?= $cod->no_hp; ?>)</td>
                        </tr>
                        <tr>
                            <th>Total Harga Barang</th>
                            <td>: <strong>Rp <?= number_format($cod->total_harga, 0, ',', '.'); ?></strong></td>
                        </tr>
                        <tr><td colspan="2"><hr></td></tr>
                        
                        <?php if($cod->dp_wajib > 0): ?>
                            <tr>
                                <th>Wajib DP (20%)</th>
                                <td class="text-primary">: Rp <?= number_format($cod->dp_wajib, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Status DP</th>
                                <td>: 
                                    <?php if ($cod->status_dp === 'diterima'): ?>
                                        <span class="badge badge-success">Sudah Diterima</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning"><?= ucfirst($cod->status_dp); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        
                        <tr>
                            <th class="text-danger" style="font-size: 1.2rem;">SISA TAGIHAN (COD)</th>
                            <td class="text-danger font-weight-bold" style="font-size: 1.2rem;">
                                : Rp <?= number_format($cod->sisa_pembayaran, 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Pelunasan</th>
                            <td>: 
                                <?php if ($cod->status_pelunasan === 'lunas'): ?>
                                    <span class="badge badge-success">LUNAS</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">BELUM LUNAS</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <?php if ( ($cod->dp_wajib == 0 || $cod->status_dp == 'diterima') && $cod->status_pelunasan == 'belum' ): ?>
                <div class="card-footer">
                    <a href="<?= base_url('admin/cod/lunasi/'.$cod->id_cod); ?>" 
                       class="btn btn-success btn-block btn-lg"
                       onclick="return confirm('Apakah kurir sudah menerima uang sejumlah Rp <?= number_format($cod->sisa_pembayaran); ?>?')">
                       <i class="fas fa-money-bill-wave"></i> TERIMA PELUNASAN COD
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($cod->dp_wajib > 0): ?>
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Verifikasi Bukti DP</h3>
                </div>
                <div class="card-body text-center">
                    <?php if ($cod->bukti_dp): ?>
                        <img src="<?= base_url('assets/uploads/bukti_dp/'.$cod->bukti_dp); ?>" class="img-fluid border rounded mb-3 shadow-sm" style="max-height: 400px;">
                        
                        <?php if ($cod->status_dp === 'menunggu'): ?>
                            <hr>
                            <p>Apakah bukti transfer DP valid?</p>
                            <a href="<?= base_url('admin/cod/verifikasi_dp/'.$cod->id_cod.'/diterima'); ?>" 
                               class="btn btn-success mr-2"
                               onclick="return confirm('Yakin terima DP ini?')">
                               <i class="fas fa-check"></i> Terima
                            </a>
                            <a href="<?= base_url('admin/cod/verifikasi_dp/'.$cod->id_cod.'/ditolak'); ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Yakin tolak DP ini?')">
                               <i class="fas fa-times"></i> Tolak
                            </a>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="alert alert-secondary">
                            <i class="fas fa-info-circle"></i> Customer belum mengupload bukti DP.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
  </div>
</section>