<?php

namespace App\Controllers;

use App\Models\BarangModel;
use CodeIgniter\Controller;
use Config\Services;

class BarangController extends Controller
{
    public function index()
    {
        $model = new BarangModel();
        $data['barang'] = $model->findAll();
    
        return view('barang/index', $data);
    }
    

    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function tambah()
    {
        $request = Services::request();
        $session = session();

        // Cek apakah metode permintaan adalah POST
        if ($request->getMethod() === 'post') {
            // Validasi input
            if (!$this->validate([
                'nama' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
                'gambar' => [
                    'uploaded[gambar]',
                    'max_size[gambar,1024]',
                    'is_image[gambar]'
                ],
                'id_kategori' => 'required|numeric'
            ])) {
                // Jika validasi gagal, tampilkan kembali form dengan pesan kesalahan
                return view('barang/form_input', [
                    'validation' => $this->validator
                ]);
            }

            // Ambil nama pengguna dari sesi
            $createdBy = $session->get('username'); // Ganti dengan key sesuai yang digunakan

            // Lakukan upload gambar jika ada
            $gambar = $request->getFile('gambar');
            if ($gambar->isValid() && !$gambar->hasMoved()) {
                $namaGambar = $gambar->getRandomName();
                $gambar->move('uploads', $namaGambar); // Perbaiki path folder untuk upload
            } else {
                return view('barang/form_input', [
                    'validation' => $this->validator
                ]);
            }

            // Siapkan data untuk disimpan ke database
            $data = [
                'nama' => $request->getPost('nama'),
                'harga' => $request->getPost('harga'),
                'stok' => $request->getPost('stok'),
                'gambar' => $namaGambar,
                'id_kategori' => $request->getPost('id_kategori'),
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $createdBy // Isi 'created_by' dengan nama pengguna
            ];

            // Insert data ke dalam database
            $model = new BarangModel();
            $model->insert($data);

            // Tampilkan form input barang dengan pesan sukses
            return view('barang/form_input', [
                'success' => 'Data barang berhasil disimpan!'
            ]);
        }

        // Tampilkan form input barang
        return view('barang/form_input');
    }
    
    public function delete($id)
{
    // Logika untuk menghapus barang dari database
    $model = new BarangModel();
    $model->delete($id);

    return redirect()->to(base_url('barang'));
}

}
