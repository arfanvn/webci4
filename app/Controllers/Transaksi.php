<?php

namespace App\Controllers;

use Dompdf\Dompdf;

class Transaksi extends BaseController
{
    protected $cart;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $id = $this->session->get('id');
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->where('id_user', $id)->findAll();
        $transaksiDetail = $transaksiModel->select('transaksi.*, transaksi_detail.*, barang.nama')->join('transaksi_detail', 'transaksi_detail.id_transaksi=transaksi.id')->join('barang', 'transaksi_detail.id_barang=barang.id')->findAll();

        return view('transaksi/index', [
            'transaksis' => $transaksi,
            'transaksiDetails' => $transaksiDetail,
        ]);
    }

    public function buy()
    {
        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $this->validation->run($data, 'transaksi');
            $errors = $this->validation->getErrors();

            if (!$errors) {
                $transaksiModel = new \App\Models\TransaksiModel();

                $transaksiDetailModel = new \App\Models\TransaksiDetailModel();

                $barangModel = new \App\Models\BarangModel();

                $masterDiskonModel = new \App\Models\MasterDiskonModel();

                $dataForm = [
                    'id_user' => $this->request->getPost('id_user'),
                    'total_harga' => $this->request->getPost('total_harga'),
                    'alamat' => $this->request->getPost('alamat'),
                    'ongkir' => $this->request->getPost('ongkir'),
                    'status' => 0,
                    'created_by' => $this->request->getPost('id_user'),
                    'created_date' => date("Y-m-d H:i:s")
                ];

                $transaksiModel->insert($dataForm);

                $last_insert_id = $transaksiModel->getInsertID();

                $tanggalHariIni = date('Y-m-d');
                $diskon = $masterDiskonModel
                    ->where('tanggal_mulai <=', $tanggalHariIni)
                    ->where('tanggal_selesai >=', $tanggalHariIni)
                    ->findAll();
                if ($diskon) {
                    foreach ($diskon as $diskon) {
                        $diskon = $diskon['diskon'];
                    }
                } else {
                    $diskon = 0;
                }

                foreach ($this->cart->contents() as $value) {
                    $dataFormDetail = [
                        'id_transaksi' => $last_insert_id,
                        'id_barang' => $value['id'],
                        'jumlah' => $value['qty'],
                        'diskon' => $diskon,
                        'subtotal_harga' => $value['qty'] * $value['price'],
                        'created_by' => $this->request->getPost('id_user'),
                        'created_date' => date("Y-m-d H:i:s")
                        //,'penunjuk' => $last_insert_id
                    ];

                    $transaksiDetailModel->insert($dataFormDetail);
                }

                $this->cart->destroy();

                return redirect()->to('transaction');
            }
        }
    }


    public function invoice()
    {
        $id = $this->request->uri->getSegment(2);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($id);

        $transaksiDetailModel = new \App\Models\TransaksiDetailModel();
        $transaksiDetail = $transaksiDetailModel->select('transaksi_detail.*, barang.nama')->join('barang', 'transaksi_detail.id_barang=barang.id')->where('id_transaksi', $id)->findAll();

        $transaksiDiskon = $transaksiDetailModel->select('diskon')->where('id_transaksi', $id)->first();
        $diskon = $transaksiDiskon->diskon;

        $userModel = new \App\Models\UserModel();
        $pembeli = $userModel->find($transaksi->id_user);

        $html = view('transaksi/invoice', [
            'transaksi' => $transaksi,
            'transaksiDetail' => $transaksiDetail,
            'pembeli' => $pembeli,
            'diskon' => $diskon
        ]);

        $filename = date('y-m-d-H-i-s') . '-invoice';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml($html);

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
        return view('transaksi/invoice');
    }
}
