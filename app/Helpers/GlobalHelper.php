<?php

class GlobalHelper
{
    /**
     ** Tandai sidebar sebagai aktif jika halaman sedang dibuka
     */
    public static function setActive($path, $active = 'active')
    {
        return call_user_func_array('Request::is', (array)$path ) ? $active : '';
    }

    /**
     ** Menghilangkan Magic Slashes PHP
     */
    public static function stripMagicSlashes($string)
    {
        return stripslashes($string);
    }
}
