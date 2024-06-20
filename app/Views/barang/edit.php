<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
</head>
<body>
    <h2>Edit Barang</h2>

    <?php if (isset($validation)): ?>
        <div><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <form action="<?= base_url('barang/edit/' . $barang->id) ?>" method="post" enctype="multipart/form-data">
        <label for="nama">Nama Barang:</label><br>
        <input type="text" id="nama" name="nama" value="<?= $barang->nama ?>"><br><br>

        <label for="harga">Harga:</label><br>
        <input type="text" id="harga" name="harga" value="<?= $barang->harga ?>"><br><br>

        <label for="stok">Stok:</label><br>
        <input type="text" id="stok" name="stok" value="<?= $barang->stok ?>"><br><br>

        <label for="gambar">Gambar:</label><br>
        <input type="file" id="gambar" name="gambar"><br><br>

        <label for="id_kategori">ID Kategori:</label><br>
        <input type="text" id="id_kategori" name="id_kategori" value="<?= $barang->id_kategori ?>"><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <button onclick="location.href='<?= base_url('barang/index') ?>'">Kembali ke Daftar Barang</button>
    <button onclick="location.href='<?= base_url('home') ?>'">Kembali ke Menu Home</button>
</body>
</html>
