<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Barang dan Kategori</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <h2>Form Input Barang</h2>

    <?php if (isset($validation)): ?>
        <div><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="popup" id="popup">
            <?= $success ?>
            <br><br>
            <button onclick="closePopup()">Tutup</button>
        </div>
        <script>
            document.getElementById('popup').style.display = 'block';

            function closePopup() {
                document.getElementById('popup').style.display = 'none';
            }
        </script>
    <?php endif; ?>

    <form action="<?= base_url('barang/tambah') ?>" method="post" enctype="multipart/form-data">
        <label for="nama">Nama Barang:</label><br>
        <input type="text" id="nama" name="nama"><br><br>

        <label for="harga">Harga:</label><br>
        <input type="text" id="harga" name="harga"><br><br>

        <label for="stok">Stok:</label><br>
        <input type="text" id="stok" name="stok"><br><br>

        <label for="gambar">Gambar:</label><br>
        <input type="file" id="gambar" name="gambar"><br><br>

        <label for="id_kategori">ID Kategori:</label><br>
        <input type="text" id="id_kategori" name="id_kategori"><br><br>

        <button type="submit">Simpan Barang</button>
    </form>

    <hr>

    <h2>Form Input Kategori</h2>

    <?php if (isset($kategoriValidation)): ?>
        <div><?= $kategoriValidation->listErrors() ?></div>
    <?php endif; ?>

    <form action="<?= base_url('kategori/tambah') ?>" method="post">
        <label for="nama_kategori">Nama Kategori:</label><br>
        <input type="text" id="nama_kategori" name="nama"><br><br>
        
        <button type="submit">Simpan Kategori</button>
    </form>

    <hr>
    <button onclick="location.href='<?= base_url('barang') ?>'">Kembali ke Daftar Barang</button>
    <button onclick="location.href='<?= base_url('../index.php/shop') ?>'">Kembali ke Menu Home</button>
</body>
</html>
