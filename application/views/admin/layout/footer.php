<?php
// ==================================================
// FOOTER + REQUIRED SCRIPTS
// ==================================================
?>

<!-- ==================================================
     MAIN FOOTER
     ================================================== -->
<footer class="main-footer">
  <strong>&copy; <?= date('Y'); ?> ZETTARIG</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Admin Panel</b>
  </div>
</footer>

</div>
<!-- /.wrapper -->

<!-- ==================================================
     CORE JAVASCRIPT (WAJIB - LOAD ONCE)
     ================================================== -->

<!-- jQuery -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?= base_url('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>

<!-- AdminLTE -->
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js'); ?>"></script>

<!-- ==================================================
     CHART.JS (WAJIB UNTUK DASHBOARD)
     ================================================== -->
<script src="<?= base_url('assets/adminlte/plugins/chart.js/Chart.min.js'); ?>"></script>

<!-- ==================================================
     DASHBOARD CHART
     PENDAPATAN vs PEMBELIAN vs PROFIT
     ================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ==================================================
  // VALIDASI CANVAS
  // ==================================================
  const canvas = document.getElementById('chartPendapatan');
  if (!canvas) return;

  // ==================================================
  // DATA DARI CONTROLLER
  // ==================================================
  const labels     = <?= json_encode($bulan_label ?? []); ?>;
  const pendapatan = <?= json_encode($bulan_pendapatan ?? []); ?>;
  const pembelian  = <?= json_encode($bulan_pembelian ?? []); ?>;

  if (!labels.length) return;

  // ==================================================
  // HITUNG PROFIT (REAL TIME)
  // ==================================================
  const profit = pendapatan.map((v, i) => v - (pembelian[i] || 0));

  // ==================================================
  // PALET WARNA ADMINLTE (BEDA TIAP BULAN)
  // ==================================================
  const warnaPendapatan = [
    '#007bff','#0069d9','#005cbf','#004085',
    '#3395ff','#5fa8ff','#1e90ff','#0b5ed7',
    '#0a58ca','#084298','#0d6efd','#3d8bfd'
  ];

  const warnaPembelian = [
    '#dc3545','#c82333','#bd2130','#a71d2a',
    '#fd7e14','#e8590c','#ff922b','#d9480f',
    '#ffc107','#e0a800','#ffca2c','#997404'
  ];

  const warnaProfit = [
    '#28a745','#218838','#1e7e34','#19692c',
    '#2ecc71','#58d68d','#20c997','#198754',
    '#157347','#146c43','#4caf50','#6fdc8c'
  ];

  // ==================================================
  // FORMAT RUPIAH (FULL + SHORT)
  // ==================================================
  function formatRupiah(value) {
    return 'Rp ' + value.toLocaleString('id-ID');
  }

  function formatRupiahShort(value) {
    const abs = Math.abs(value);
    if (abs >= 1000000000) {
      return 'Rp ' + (value / 1000000000).toFixed(1).replace('.', ',') + ' M';
    }
    if (abs >= 1000000) {
      return 'Rp ' + (value / 1000000).toFixed(1).replace('.', ',') + ' Jt';
    }
    return formatRupiah(value);
  }

  // ==================================================
  // INISIALISASI CHART
  // ==================================================
  new Chart(canvas, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Pendapatan',
          data: pendapatan,
          backgroundColor: warnaPendapatan,
          borderRadius: 4
        },
        {
          label: 'Pembelian',
          data: pembelian,
          backgroundColor: warnaPembelian,
          borderRadius: 4
        },
        {
          label: 'Profit',
          data: profit,
          backgroundColor: warnaProfit,
          borderRadius: 4
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,

      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function (value) {
              return formatRupiahShort(value);
            }
          }
        }
      },

      plugins: {
        tooltip: {
          callbacks: {
            title: function (items) {
              return items[0].label;
            },
            label: function (ctx) {
              return ctx.dataset.label + ': ' + formatRupiahShort(ctx.raw);
            }
          }
        },
        legend: {
          labels: {
            color: '#ffffff'
          }
        }
      }
    }
  });

});
</script>


<!-- ==================================================
     GLOBAL LIVE IMAGE PREVIEW (PRODUK + BRAND)
     ================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {

  const produkInput   = document.getElementById('input-gambar');
  const produkPreview = document.getElementById('preview-gambar');

  if (produkInput && produkPreview) {
    produkInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        produkPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }

  const brandInput   = document.getElementById('input-logo');
  const brandPreview = document.getElementById('preview-logo');

  if (brandInput && brandPreview) {
    brandInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        brandPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }

});
</script>

</body>
</html>
