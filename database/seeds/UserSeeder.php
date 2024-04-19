<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [ 
            [
                'u_nama' => 'Administrator',
                'u_username' => 'admin',
                'u_email' => 'admin@gmail.com',
                'u_password' => bcrypt('admin123098'),
                'u_password_raw' => 'admin123098',
                'r_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
