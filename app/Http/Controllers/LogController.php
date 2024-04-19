<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Utils\Datatable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LogController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman log sistem.
     *
     * @return view
     */
    public function index()
    {
        if (auth()->user()->can('View Log')) {
            return view('dashboard.log.index');
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Log Sistem!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menampilkan datatable.
     *
     * @param Request $request
     * @return json
     */
    public function datatable(Request $request)
    {
        $params = [
            "querymode" => 'model',
            "querytarget" => \App\Models\Log::class,
            "order"  => [['column' => 'created_at', 'order' => 'DESC']]
        ];
        
        $result = new Datatable($request, $params);

        return $result->getdatatable();
    }
    
}
