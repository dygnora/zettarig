<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Transaksi</title>
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
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
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
        .badge {
            padding: 2px 5px;
            border: 1px solid #ccc;
            font-size: 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN DETAIL TRANSAKSI</h2>
        <p>Toko Komputer Zettarig</p>
    </div>

    <div class="meta-info">
        <table style="border: none; margin-top: 0;">
            <tr>
                <td style="border: none; width: 150px;"><strong>Nama Customer</strong></td>
                <td style="border: none;">: <?= htmlspecialchars($customer->nama); ?></td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Periode Laporan</strong></td>
                <td style="border: none;">: 
                    <?= ($start && $end) ? date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end)) : 'Semua Waktu'; ?>
                </td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Dicetak Pada</strong></td>
                <td style="border: none;">: <?= date('d F Y H:i'); ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Produk</th>
                <th width="40">Qty</th>
                <th width="70">Metode</th>
                <th width="80">Status</th>
                <th width="100">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;

            if (!empty($detail)):
                foreach ($detail as $d): 
                    $grand_total += $d->subtotal;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($d->tanggal_pesanan)); ?></td>
                <td><?= htmlspecialchars($d->nama_produk); ?></td>
                <td class="text-center"><?= $d->jumlah; ?></td>
                <td class="text-center"><?= strtoupper($d->metode_pembayaran); ?></td>
                <td class="text-center"><?= ucfirst($d->status_pesanan); ?></td>
                <td class="text-right">Rp <?= number_format($d->subtotal, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="grand-total">
                <td colspan="6" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>