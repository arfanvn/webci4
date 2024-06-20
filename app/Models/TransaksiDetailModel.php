<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_transaksi', 'id_barang', 'jumlah', 'diskon', 'subtotal_harga', 'created_date', 'created_by', 'updated_date', 'updated_by', 'penunjuk'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = false;
}
