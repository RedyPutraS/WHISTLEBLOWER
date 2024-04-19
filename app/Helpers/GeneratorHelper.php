<?php

namespace App\Helpers;

class GeneratorHelper
{
    /**
     ** Buat format nomor registrasi pengaduan
     */
    public static function generateNoreg($totalcharacter = 4, $separator = '/')
    {
        $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomstring = '';

        for ($i = 0; $i < $totalcharacter; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomstring .= $characters[$index];
        }
        return $randomstring . $separator . date('Y');
    }
}
