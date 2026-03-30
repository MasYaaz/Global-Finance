<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Seed Companies
        $db->table('companies')->insertBatch([
            ['name' => 'PT Maju'],
            ['name' => 'PT Jaya'],
        ]);

        // Seed Users
        $db->table('users')->insertBatch([
            [
                'username' => 'admin',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'company_id' => null
            ],
            [
                'username' => 'manager_maju',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'company_id' => 1
            ],
            [
                'username' => 'direktur',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'director',
                'company_id' => null
            ],
            [
                'username' => 'manager_jaya',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'company_id' => 2
            ],
        ]);

        // Seed Users
        // $db->table('users')->insertBatch([
        //     

        // ]);
    }
}