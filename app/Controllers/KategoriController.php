<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Controller;

class KategoriController extends Controller
{
    public function tambah()
    {
        $request = \Config\Services::request();
        $session = session();


        if ($request->getMethod() === 'post') {
      
            if (!$this->validate([
                'nama' => 'required'
            ])) {
              
                return view('kategori/form_input', [
                    'validation' => $this->validator
                ]);
            }

          
            $createdBy = $session->get('username'); 

    
            $data = [
                'nama' => $request->getPost('nama'),
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $createdBy 
            ];

       
            $model = new KategoriModel();
            $model->insert($data);

            return redirect()->to(base_url('kategori/index'));
        }

       
        return view('kategori/form_input');
        
    }

    
}
