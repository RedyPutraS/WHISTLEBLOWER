<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
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
                's_nama' => 'Diterima',
                's_urutan' => 1,
                's_deskripsi' => 'Laporan telah diterima',
                's_warna_background' => '#9fcc2e',
                's_warna_teks' => '#ffffff',
                's_label' => 'Global',
                's_keterangan' => 'Status ini muncul secara umum',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                's_nama' => 'Ditolak',
                's_urutan' => 2,
                's_deskripsi' => 'Laporan telah ditolak karena terdeteksi sebagai SPAM',
                's_warna_background' => '#373c43',
                's_warna_teks' => '#ffffff',
                's_label' => 'Global',
                's_keterangan' => 'Status ini muncul secara umum',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                's_nama' => 'Diproses',
                's_urutan' => 3,
                's_deskripsi' => 'Laporan sedang diproses. Keterangan investigator:',
                's_warna_background' => '#fa9f1b',
                's_warna_teks' => '#ffffff',
                's_label' => 'Global',
                's_keterangan' => 'Status ini hanya muncul sebagai hasil investigasi di tahap penyelidikan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                's_nama' => 'Kurang Bukti',
                's_urutan' => 4,
                's_deskripsi' => 'Laporan kekurangan bukti. Keterangan investigator:',
                's_warna_background' => '#e1e7f0',
                's_warna_teks' => '#25476a',
                's_label' => 'Penyidikan',
                's_keterangan' => 'SStatus ini hanya muncul sebagai hasil investigasi di tahap penyelidikan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                's_nama' => 'Terbukti',
                's_urutan' => 5,
                's_deskripsi' => 'Laporan terbukti. Keterangan investigator:',
                's_warna_background' => '#df5645',
                's_warna_teks' => '#ffffff',
                's_label' => 'Penyidikan',
                's_keterangan' => 'Status ini hanya muncul sebagai hasil investigasi di tahap penyidikan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                's_nama' => 'Tidak Terbukti',
                's_urutan' => 6,
                's_deskripsi' => 'Laporan tidak terbukti. Keterangan investigator:',
                's_warna_background' => '#373c43',
                's_warna_teks' => '#ffffff',
                's_label' => 'Penyidikan',
                's_keterangan' => 'Status ini hanya muncul sebagai hasil investigasi di tahap penyidikan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('status')->insert($data);
    }
}
