<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivilegeSeeder extends Seeder
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
                'pg_nama' => 'User',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'Role',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'Privilege',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'Complaint',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'Discussion',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'CMS',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'Setting',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pg_nama' => 'Status',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('privilegegroup')->insert($data);

        $privilegegroups = DB::table('privilegegroup')->select('pg_id')->get();

        $privilegenames = [
            'MANAGE' => "Manage",
            'VIEW' => "View",
            'VIEW_OWN' => "View_Own",
            'ADD' => "Add",
            'ADD_OWN' => "Add_Own",
            'EDIT' => "Edit",
            'EDIT_OWN' => "Edit_Own",
            'REMOVE' => "Delete",
            'REMOVE_OWN' => "Delete_Own",
        ];

        /*
        * Masukkan semua isi privilege yang tersedia ke semua privilege group
        */
        $privileges = [];
        foreach ($privilegegroups as $key => $privilegegroup) {
            foreach ($privilegenames as $key2 => $privilegename) {
                $privileges[] = [
                    'pg_id' => $privilegegroup->pg_id,
                    'p_nama' => $privilegename,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        DB::table('privilege')->insert($privileges);
    }
}
