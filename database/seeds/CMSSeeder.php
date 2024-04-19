<?php

use Illuminate\Database\Seeder;

class CMSSeeder extends Seeder
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
                'cms_label' => 'Ucapan Selamat Datang',
                'cms_halaman' => 'Beranda',
                'cms_image' => 'img-beranda.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Kata Pengantar',
                'cms_halaman' => 'Beranda',
                'cms_image' => 'img-beranda.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Tindak Lanjut',
                'cms_halaman' => 'Beranda',
                'cms_image' => 'img-beranda.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Kata Pengantar',
                'cms_halaman' => 'Form Pengaduan',
                'cms_image' => 'img-form-pengaduan.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Ucapan Terima Kasih',
                'cms_halaman' => 'Info Pengaduan',
                'cms_image' => 'img-status-pengaduan.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Disclaimer',
                'cms_halaman' => 'Info Pengaduan',
                'cms_image' => 'img-status-pengaduan.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Judul',
                'cms_halaman' => 'Detail Pengaduan',
                'cms_image' => 'img-detail-pengaduan.jpg',
                'cms_input_type' => 'text',
                'cms_urutan' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Judul',
                'cms_halaman' => 'Hasil Pengaduan',
                'cms_image' => 'img-hasil-pengaduan.jpg',
                'cms_input_type' => 'text',
                'cms_urutan' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Judul',
                'cms_halaman' => 'Tanya Tim',
                'cms_image' => 'img-tanya-tim.jpg',
                'cms_input_type' => 'text',
                'cms_urutan' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Judul',
                'cms_halaman' => 'Status Pengaduan',
                'cms_image' => 'img-status-pengaduan.jpg',
                'cms_input_type' => 'text',
                'cms_urutan' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Isi',
                'cms_halaman' => 'Status Pengaduan',
                'cms_image' => 'img-status-pengaduan.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Keterangan',
                'cms_halaman' => 'Status Pengaduan',
                'cms_image' => 'img-status-pengaduan.jpg',
                'cms_input_type' => 'textarea',
                'cms_urutan' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'cms_label' => 'Gambar Banner',
                'cms_halaman' => 'Beranda',
                'cms_image' => 'img-beranda.jpg',
                'cms_input_type' => 'file',
                'cms_urutan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('cms')->insert($data);
    }
}
