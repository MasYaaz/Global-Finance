<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFinanceTables extends Migration
{
    public function up()
    {
        // Table Companies
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('companies');

        // Table Users
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'ENUM', 'constraint' => ['admin', 'manager', 'director']],
            'company_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // Table Transactions
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'company_id' => ['type' => 'INT', 'constraint' => 11],
            'type' => ['type' => 'ENUM', 'constraint' => ['debit', 'kredit']],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'description' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
        $this->forge->dropTable('users');
        $this->forge->dropTable('companies');
    }
}