<?php

namespace App\Controllers;

class Shop extends BaseController
{
    protected $session;
    protected $cart;
    private $url = "https://api.rajaongkir.com/starter/";
    private $apiKey = "05988ef176eba0d92152496e169502b9";

    public function __construct()
    {
        helper('form');
        $this->session = session();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $barangModel = new \App\Models\BarangModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $barang = $barangModel->select('barang.*, kategori.nama AS kategori')->join('kategori', 'barang.id_kategori=kategori.id')->findAll();
        $kategori = $kategoriModel->findAll();
        return view('shop/index', [
            'barangs' => $barang,
            'kategoris' => $kategori,
        ]);
    }

    public function category()
    {
        $id = $this->request->uri->getSegment(3);

        $barangModel = new \App\Models\BarangModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $barang = $barangModel->select('barang.*, kategori.nama AS kategori')->where('id_kategori', $id)->join('kategori', 'barang.id_kategori=kategori.id')->where('id_kategori', $id)->findAll();
        $kategori = $kategoriModel->findAll();
        return view('shop/index', [
            'barangs' => $barang,
            'kategoris' => $kategori,
        ]);
    }

    public function product()
    {
        $id = $this->request->uri->getSegment(3);

        $barangModel = new \App\Models\BarangModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $komentarModel = new \App\Models\KomentarModel();
        $barang = $barangModel->find($id);
        $kategori = $kategoriModel->findAll();
        $komentar = $komentarModel->select('komentar.*, user.username')->join('transaksi_detail', 'komentar.id_transaksi_detail=transaksi_detail.id')->join('transaksi', 'transaksi_detail.id_transaksi=transaksi.id')->join('user', 'transaksi.id_user=user.id')->where('id_barang', $id)->findAll();

        return view('shop/product', [
            'barang' => $barang,
            'kategoris' => $kategori,
            'komentars' => $komentar,
        ]);
    }

    public function cart_show()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        // Ambil tanggal hari ini
        $tanggalHariIni = date('Y-m-d');

        // Ambil data diskon dari tabel master_diskon yang berlaku untuk hari ini
        $masterDiskonModel = new \App\Models\MasterDiskonModel();
        $diskon = $masterDiskonModel
            ->where('tanggal_mulai <=', $tanggalHariIni)
            ->where('tanggal_selesai >=', $tanggalHariIni)
            ->findAll();

        $data['diskon'] = $diskon;

        return view('shop/cart', $data);
    }

    public function cart_add()
    {
        $this->cart->insert(array(
            'id'    => $this->request->getPost('id'),
            'qty'   => 1,
            'price'    => $this->request->getPost('hrg'),
            'name'    => $this->request->getPost('nama'),
            'options' => array('foto' => $this->request->getPost('foto'))
        ));
        //session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (Lihat)');
        return redirect()->to(base_url('shop'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        return redirect()->to(base_url('shop'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        //session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('cart'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        //session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('cart'));
    }

    public function cart_checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        $provinsi = $this->rajaongkir('province');
        $data['provinsi'] = json_decode($provinsi)->rajaongkir->results;

        // Ambil tanggal hari ini
        $tanggalHariIni = date('Y-m-d');

        // Ambil data diskon dari tabel master_diskon yang berlaku untuk hari ini
        $masterDiskonModel = new \App\Models\MasterDiskonModel();
        $diskon = $masterDiskonModel
            ->where('tanggal_mulai <=', $tanggalHariIni)
            ->where('tanggal_selesai >=', $tanggalHariIni)
            ->findAll();

        $data['diskon'] = $diskon;

        return view('shop/checkout', $data);
    }

    public function getCity()
    {
        if ($this->request->isAJAX()) {
            $id_province = $this->request->getGet('id_province');
            $data = $this->rajaongkir('city', $id_province);
            return $this->response->setJSON($data);
        }
    }

    public function getCost()
    {
        if ($this->request->isAJAX()) {
            $origin = $this->request->getGet('origin');
            $destination = $this->request->getGet('destination');
            $weight = $this->request->getGet('weight');
            $courier = $this->request->getGet('courier');
            $data = $this->rajaongkircost($origin, $destination, $weight, $courier);
            return $this->response->setJSON($data);
        }
    }

    private function rajaongkircost($origin, $destination, $weight, $courier)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . $this->apiKey,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }


    private function rajaongkir($method, $id_province = null)
    {
        $endPoint = $this->url . $method;

        if ($id_province != null) {
            $endPoint = $endPoint . "?province=" . $id_province;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . $this->apiKey
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}
