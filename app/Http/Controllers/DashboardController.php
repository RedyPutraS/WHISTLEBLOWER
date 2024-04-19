<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulirpengaduan;
use App\Models\Status;
use App\Helpers\ResponseHelper;
use Carbon\Carbon;

class DashboardController extends BaseController
{
    public function index()
    {
        $statuses = Status::active()->orderBy('s_urutan')->get();
        foreach ($statuses as $key => $status) {
            $stats[] = [
                'name' => $status->s_nama,
                'total' => count($status->formulirpengaduan),
            ];
        }
        $stats = json_decode(json_encode($stats));

        $previousday = date('Y-m-d H:i:s', strtotime('-7 day', strtotime(date('Y-m-d H:i:s'))));
        $complaintactivities = Formulirpengaduan::active()->whereBetween('updated_at', [$previousday, date('Y-m-d H:i:s')])->get();
        
        return view('dashboard.index', compact('stats', 'complaintactivities'));
    }

    public function getnotification(Request $request)
    {
        if($request->ajax()){
            try{
                $time = Formulirpengaduan::active()->select('created_at', 's_id')->where('s_id', 1)->orderby('created_at','DESC')->first()->created_at;

                $total = Formulirpengaduan::active()
                    ->where('s_id', 1) // Hanya memunculkan notifikasi yang statusnya "Diterima"
                    ->count();

                $data = [
                    'total' => $total,
                    'time' => Carbon::parse($time)->diffForHumans()
                ];

                $response = ResponseHelper::response(true, 'Sukses', $data);
                return $response;
            }
            catch(\Exception $e){
                $response = ResponseHelper::response(false, 'Sukses', $e->getMessage());
                return $response;
            }
        }
    }

    public function getchart(Request $request){
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        for($i=1;$i<=12;$i++){
            $data['laporan_selesai'][] = Formulirpengaduan::active()->whereMonth('f_tanggal_masuk',$i)
                                                                    ->whereYear('f_tanggal_masuk',$request->year)
                                                                    ->whereHas('status', function ($query) {
                                                                        $query->where('s_urutan', 4)
                                                                        ->orwhere('s_urutan', 5)
                                                                        ->orwhere('s_urutan', 6);
                                                                    })->count();

            $data['laporan_masuk'][] = Formulirpengaduan::active()->whereMonth('f_tanggal_masuk',$i)
                                                                    ->whereYear('f_tanggal_masuk',$request->year)
                                                                    ->count();
            $data['reportrealizations'][] = [
                'month' => $months[$i-1],
                'total' => $data['laporan_masuk'][$i-1],
            ];

            if ($data['laporan_masuk'][$i-1] == 0) {
                $data['reportrealizations'][$i-1]['percentage'] = 0;
            }
            else {
                $data['reportrealizations'][$i-1]['percentage'] = number_format(($data['laporan_selesai'][$i-1] / $data['laporan_masuk'][$i-1]) * 100, 2, ',', '.');
            }            
        }

        return $data;
    }

    public function help()
    {
        return view('dashboard.help');
    }
}
