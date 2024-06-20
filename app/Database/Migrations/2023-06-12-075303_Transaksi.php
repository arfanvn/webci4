<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
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
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'total_harga' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'alamat' => [
                'type' => 'TEXT'
            ],
            'ongkir' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
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
        $this->forge->createTable('transaksi');

        $this->forge->addColumn('transaksi', [
            'CONSTRAINT transaksi_ud_pembeli FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE NO ACTION ON UPDATE NO ACTION',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
