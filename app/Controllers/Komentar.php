<?php

namespace App\Controllers;

class Komentar extends BaseController
{
    protected $validation;
    protected $session;
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function create()
    {
        $model = new \App\Models\KomentarModel();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $this->validation->run($data, 'komentar');
            $errors = $this->validation->getErrors();

            if (!$errors) {
                $id_tansaksi_detail_barang = explode('_', $this->request->getPost('id_tansaksi_detail_barang'));

                $dataForm = [
                    'id_transaksi_detail' => $id_tansaksi_detail_barang[0],
                    'komentar' => $this->request->getPost('komentar'),
                    'created_by' => $this->request->getPost('id_user'),
                    'created_date' => date("Y-m-d H:i:s")
                ];

                $model->insert($dataForm);

                $segments = ['shop', 'product', $id_tansaksi_detail_barang[1]];

                return redirect()->to(site_url($segments));
            }
        }
    }
}
