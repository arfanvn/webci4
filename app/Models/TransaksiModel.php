<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'id_user', 'total_harga', 'alamat', 'ongkir', 'status', 'created_date', 'created_by', 'updated_date', 'updated_by'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = false;
}
