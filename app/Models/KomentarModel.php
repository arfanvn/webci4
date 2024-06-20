<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table = 'komentar';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_transaksi_detail', 'komentar', 'created_date', 'created_by', 'updated_date', 'updated_by'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = false;
}
