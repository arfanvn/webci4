<!-- File: app/Views/barang/create.php -->
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Tambah Barang</h2>
<form action="<?= base_url('/barang/store') ?>" method="post">
    <div class="form-group">
        <label for="nama">Nama Barang</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" required>
    </div>
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" required>
    </div>
    <!-- Tambahkan input fields lain sesuai kebutuhan -->
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection() ?>
<!-- create by arfan nur ivandi -->