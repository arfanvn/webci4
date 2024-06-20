<html>

<head>
    <title>Invoice</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="font-size:64px; color:'#dddddd' "><i>Invoice</i></div>
    <p>
        <i>Toko Online</i><br>
        Semarang, Indonesia<br>
        024123456
    </p>
    <hr>
    <hr>
    <p></p>
    <p>
        Pembeli : <?= $pembeli->username ?><br>
        Alamat : <?= $transaksi->alamat ?><br>
        Transaksi No : <?= $transaksi->id ?><br>
        Tanggal : <?= date('Y-m-d', strtotime($transaksi->created_date)) ?>
    </p>
    <table cellpadding="6">
        <tr>
            <th><strong>Barang</strong></th>
            <th><strong>Jumlah</strong></th>
            <th><strong>Subtotal Harga</strong></th>
        </tr>
        <?php
        foreach ($transaksiDetail as $item) :
        ?>
            <tr>
                <td><?= $item->nama ?></td>
                <td><?= $item->jumlah ?></td>
                <td><?= "Rp " . number_format($item->subtotal_harga, 2, ',', '.') ?></td>
            </tr>
        <?php
        endforeach;
        ?>
        <tr>
            <td colspan="2">Ongkir</td>
            <td><?= "Rp " . number_format($transaksi->ongkir, 2, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="2">Diskon</td>
            <td><?= $diskon ?>%</td>
        </tr>
        <tr>
            <td colspan="2">Total Harga</td>
            <td><?= "Rp " . number_format($transaksi->total_harga, 2, ',', '.') ?></td>
        </tr>
    </table>
</body>

</html>