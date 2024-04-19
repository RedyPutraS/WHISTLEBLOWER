<?php

namespace App\Helpers;

class ResponseHelper
{
     
    /**
     * Fungsi ini mengembalikan response data
     *
     * @param  mixed $success
     * @param  mixed $message
     * @param  mixed $data
     * @return void
     */
    public static function response($success=true,$message='',$data=''){
        return [
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ];
    }

    
}