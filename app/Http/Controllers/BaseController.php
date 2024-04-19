<?php

namespace App\Http\Controllers;

use App\Models\Formulirpengaduan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;

class BaseController extends Controller
{
    public function __construct()
    {
        $countreport = Formulirpengaduan::active()->where('f_tanggal_masuk', date('Y-m-d'))->count();
        $data = [
            'countreport' => $countreport
        ];
        View::share('data',$data);
    }  

}