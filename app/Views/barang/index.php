<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
</head>
<body>
    <h2>Daftar Barang</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>ID Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $item): ?>
                <tr>
                    <td><?= $item->id ?></td>
                    <td><?= $item->nama ?></td>
                    <td><?= $item->harga ?></td>
                    <td><?= $item->stok ?></td>
                    <td><img src="<?= base_url('uploads/' . $item->gambar) ?>" width="100"></td>
                    <td><?= $item->id_kategori ?></td>
                    <td>
                        <a href="<?= base_url('barang/edit/' . $item->id) ?>">Edit</a>
                        <a href="<?= base_url('barang/delete/' . $item->id) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button onclick="location.href='<?= base_url('barang/tambah') ?>'">Tambah Barang</button>
    <button onclick="location.href='<?= base_url('home') ?>'">Kembali ke Menu Home</button>
</body>
</html>
