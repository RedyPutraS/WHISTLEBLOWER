<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
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
                'r_nama' => 'Administrator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'r_nama' => 'Investigator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'r_nama' => 'Technical',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('role')->insert($data);

        /*
        * Masukkan semua privilege yang tersedia ke role "Administrator"
        */
        $roleadmin = DB::table('role')->where('r_nama', 'Administrator')->value('r_id');
        $privileges = DB::table('privilege')->select('p_id')->get();

        $role_privilege = [];
        foreach ($privileges as $privilege) {
            $role_privilege[] = [
                'p_id' => $privilege->p_id,
                'r_id' => $roleadmin,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('role_privilege')->insert($role_privilege);
    }
}
