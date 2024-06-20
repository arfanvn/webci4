<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiDetail extends Migration
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
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'diskon' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'subtotal_harga' => [
                'type' => 'INT',
                'constraint' => 11,
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
        $this->forge->createTable('transaksi_detail');

        $this->forge->addColumn('transaksi_detail', [
            'CONSTRAINT transaksi_detail_id_transaksi_foreign FOREIGN KEY(id_transaksi) REFERENCES transaksi(id) ON DELETE NO ACTION ON UPDATE NO ACTION',
        ]);
        $this->forge->addColumn('transaksi_detail', [
            'CONSTRAINT transaksi_detail_id_barang_foreign FOREIGN KEY(id_barang) REFERENCES barang(id) ON DELETE NO ACTION ON UPDATE NO ACTION',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_detail');
    }
}
