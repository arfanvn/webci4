<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterDiskonModel extends Model
{
    protected $table = 'master_diskon';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tanggal_mulai',
        'tanggal_selesai',
        'diskon',
        'created_by',
        'created_date',
        'updated_by',
        'updated_date',
    ];

    protected $useTimestamps = false;
    //protected $returnType = 'object';

    // Metode lain yang Anda butuhkan

}
