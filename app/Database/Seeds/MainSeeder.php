<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();



        // Seed Users
        $db->table('users')->insertBatch([
            [
                'username' => 'manager_jaya',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'company_id' => 1
            ],

        ]);
    }
}