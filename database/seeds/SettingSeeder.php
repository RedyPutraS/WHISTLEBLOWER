<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class SettingSeeder extends Seeder
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
                'pgtr_nama' => 'Waktu Tindak Lanjut',
                'pgtr_nilai' => '1',
                'pgtr_label' => 'Pengaduan',
                'pgtr_input_type' => 'number',
                'pgtr_note' => 'Menggunakan satuan hari',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Mailer',
                'pgtr_nilai' => 'smtp',
                'pgtr_label' => 'Konfigurasi SMTP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Host',
                'pgtr_nilai' => 'smtp.googlemail.com',
                'pgtr_label' => 'Konfigurasi SMTP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Port',
                'pgtr_nilai' => '587',
                'pgtr_label' => 'Konfigurasi SMTP Email',
                'pgtr_input_type' => 'number',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Username',
                'pgtr_nilai' => 'hifhardwear17@gmail.com',
                'pgtr_label' => 'Konfigurasi SMTP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Password',
                'pgtr_nilai' => 'kkndozxluypfixhe',
                'pgtr_label' => 'Konfigurasi SMTP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Enkripsi',
                'pgtr_nilai' => 'tls',
                'pgtr_label' => 'Konfigurasi SMTP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Batas Unggah File (kb)',
                'pgtr_nilai' => '10240',
                'pgtr_label' => 'Konfigurasi File Upload',
                'pgtr_input_type' => 'number',
                'pgtr_note' => 'Pastikan ukuran file yang diatur disini sesuai dengan kapasitas server!',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Media Pelapor',
                'pgtr_nilai' => "['Whatsapp', 'Telepon', 'SMS', 'Surat', 'Telegram']",
                'pgtr_label' => 'Pengaduan',
                'pgtr_input_type' => 'text',
                'pgtr_note' => 'Gunakan tanda koma sebagai separator/tanda pemisah antar value!',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Email',
                'pgtr_nilai' => "hifhardwear17@gmail.com",
                'pgtr_label' => 'Konfigurasi IMAP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Password',
                'pgtr_nilai' => "efemcuumhluskjms",
                'pgtr_label' => 'Konfigurasi IMAP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'IMAP',
                'pgtr_nilai' => "{imap.gmail.com:993/imap/ssl}INBOX",
                'pgtr_label' => 'Konfigurasi IMAP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Direktori',
                'pgtr_nilai' => "\storage\email",
                'pgtr_label' => 'Konfigurasi IMAP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Encoding',
                'pgtr_nilai' => "UTF-8",
                'pgtr_label' => 'Konfigurasi IMAP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Mode',
                'pgtr_nilai' => "true",
                'pgtr_label' => 'Konfigurasi IMAP Email',
                'pgtr_input_type' => 'text',
                'pgtr_note' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Jumlah Huruf Acak',
                'pgtr_nilai' => 4,
                'pgtr_label' => 'Format Nomor Laporan',
                'pgtr_input_type' => 'number',
                'pgtr_note' => 'Format laporan: XXXX/YYYY dimana X adalah huruf acak sebanyak jumlah huruf acak, / adalah tanda pisah, dan YYYY adalah tahun laporan dibuat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'pgtr_nama' => 'Tanda Pisah',
                'pgtr_nilai' => "/",
                'pgtr_label' => 'Format Nomor Laporan',
                'pgtr_input_type' => 'text',
                'pgtr_note' => 'Format laporan: XXXX/YYYY dimana X adalah huruf acak sebanyak jumlah huruf acak, / adalah tanda pisah, dan YYYY adalah tahun laporan dibuat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('pengaturan')->insert($data);
    }
}
