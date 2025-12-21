<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
        }
        .meta-info {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .grand-total {
            background-color: #ffffcc;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Penjualan</h2>
        <p>Toko Komputer Zettarig</p>
    </div>

    <div class="meta-info">
        <strong>Periode:</strong> 
        <?= ($start && $end) ? date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end)) : 'Semua Waktu'; ?>
        <br>
        <strong>Dicetak pada:</strong> <?= date('d F Y H:i'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Customer</th>
                <th width="80">Transaksi</th>
                <th width="120">Transaksi Terakhir</th>
                <th width="120">Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;

            if (!empty($laporan)):
                foreach ($laporan as $r): 
                    $grand_total += $r->total_belanja;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($r->nama_customer); ?></td>
                <td class="text-center"><?= $r->total_transaksi; ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($r->tanggal_transaksi)); ?></td>
                <td class="text-right">Rp <?= number_format($r->total_belanja, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="grand-total">
                <td colspan="4" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>