<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Komentar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'id_transaksi_detail' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'komentar' => [
                'type' => 'TEXT',
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_date' => [
                'type' => 'DATETIME',
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('komentar');

        $this->forge->addColumn('komentar', [
            'CONSTRAINT komentar_id_transaksi_detail_foreign FOREIGN KEY(id_transaksi_detail) REFERENCES transaksi_detail(id) ON DELETE NO ACTION ON UPDATE NO ACTION',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('komentar');
    }
}
