<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterDiskon extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal_mulai' => [
                'type' => 'date',
            ],
            'tanggal_selesai' => [
                'type' => 'date',
            ],
            'diskon' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'created_by' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'created_date' => [
                'type' => 'datetime',
            ],
            'updated_by' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true,
            ],
            'updated_date' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('master_diskon');
    }

    public function down()
    {
        $this->forge->dropTable('master_diskon');
    }
}
