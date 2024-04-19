<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulirpengaduan;
use App\Models\Status;
use Alert;
use App\Helpers\ResponseHelper;
use Carbon\Carbon;

class ReportController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman laporan.
     *
     * @return view
     */
    public function index()
    {
        $statuses = Status::active()->orderBy('s_urutan')->get();
        foreach ($statuses as $key => $status) {
            $stats[] = [
                'name' => $status->s_nama,
                'total' => count(Formulirpengaduan::active()->where('s_id', $status->s_id)->whereMonth('f_tanggal_masuk', date('m'))->get()),
            ];
        }
        $stats = json_decode(json_encode($stats));

        $previousday = date('Y-m-d H:i:s', strtotime('-7 day', strtotime(date('Y-m-d H:i:s'))));
        $complaintactivities = Formulirpengaduan::active()->whereBetween('updated_at', [$previousday, date('Y-m-d H:i:s')])->get();

        return view('dashboard.report.index', compact('stats', 'complaintactivities'));
    }

    /**
     * * Fungsi ini akan memvalidasi nomor registrasi dan token laporan.
     *
     * @return view
     */
    public function check(Request $request)
    {
        $rules = [
            'f_noreg' => 'required',
            'f_token' => 'required',
        ];

        $rulesMessages = [
            'required' => ':attribute wajib diisi!',
            'array' => ':attribute wajib diisi!',
        ];

        $attributes = [
            'f_noreg' => 'Nomor registrasi laporan',
            'f_token' => 'Token',
        ];

        $validator = Validator::make($request->all(), $rules, $rulesMessages, $attributes);
        
        if ($validator->fails()) {
            Alert::warning('Gagal', $validator->messages()->first());
            return redirect()->back();
        }

        $complaint = Formulirpengaduan::where(['f_noreg' => $request->f_noreg, 'f_token' => $request->f_token])->first();

        if (!$complaint) {
            Alert::warning('Gagal', 'Laporan tidak ditemukan!');
            return redirect()->back();
        }

        return redirect()->route('report.print', Crypt::encrypt($complaint->f_id));
    }

    public function print($id)
    {
        try {
            $complaint = Formulirpengaduan::find(Crypt::decrypt($id));

            return view('dashboard.report.print', compact('complaint'));
        } 
        catch (\Exception $e) {
            Alert::warning('Gagal', $e->getMessage());
            return redirect()->back();
        }
    }
}
