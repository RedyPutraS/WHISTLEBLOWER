<?php

namespace App\Http\Controllers;

use App\Models\Diskusi;
use App\Models\Formulirpengaduan;
use App\Models\FormulirpengaduanBukti;
use App\Models\FormulirpengaduanRiwayat;
use App\Models\RuangDiskusi;
use App\Models\CMS;
use App\Models\Pengaturan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\GeneratorHelper;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplaintNotification;

class FrontController extends Controller
{
    /**
     * fungsi index halaman beranda
     *
     * @return void
     */
    public function index() {
        $cms = CMS::active()->where('cms_halaman', 'Beranda')->pluck('cms_konten', 'cms_label');
        Session::forget('token');

        return view('front.index', compact('cms'));
    }

    /**
     * fungsi ini untuk menampilkan halaman buat laporan
     *
     * @return void
     */
    public function createreport() {
        $cms = CMS::active()->where('cms_halaman', 'Form Pengaduan')->pluck('cms_konten', 'cms_label');
        $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');

        return view('front.createreport', compact('cms', 'filesizelimit'));
    }

    /**
     * fungsi ini untuk menambah laporan baru
     *
     * @param  mixed $request
     * @return void
     */
    public function storereport(Request $request)
    {
        $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');
        $complaintcodeformat = Pengaturan::active()->where('pgtr_label', 'Format Nomor Laporan')->pluck('pgtr_nilai', 'pgtr_nama');

        $rules = [
            'f_waktu_kejadian' => 'required',
            'f_tempat_kejadian' => 'required',
            'f_kronologi' => 'required',
            'fb_file_bukti.*' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,gif,jpeg,png,mp4.mpeg,mp3,mkv,ogg|max:'.$filesizelimit,
            'g-recaptcha-response' => 'captcha'
        ];

        if ($request->f_email) {
            $rules['f_email'] = 'email:dns,rfc,filter';
        }

        $attributes = [
            'f_nama' => 'Nama & Instansi Pelapor',
            'f_no_telepon' => 'No. Telepon/HP',
            'f_email' => 'Email',
            'f_waktu_kejadian' => 'Waktu kejadian',
            'f_tempat_kejadian' => 'Tempat kejadian',
            'f_kronologi' => 'Kronologi',
            'fb_file_bukti.*' => 'Bukti',
            'g-recaptcha-response' => 'Captcha'
        ];

        $rules_message = [
            'required' => ':attribute wajib diisi!',
            'captcha' => ':attribute wajib diisi!',
            'email' => 'Format :attribute tidak sesuai standar!',
            'fb_file_bukti.*.mimes' => 'Format :attribute tidak diizinkan!',
            'fb_file_bukti.*.max' => 'Ukuran :attribute maksimal ' . $filesizelimit . ' kb!',
        ];

        $validator = Validator::make($request->all(), $rules, $rules_message, $attributes);
        if ($validator->fails()) {
            Alert::warning('Gagal', $validator->errors()->first())->showConfirmButton("OK");
            return redirect()->back()->withInput($request->all());
        }

        try{
            DB::beginTransaction();

            do {
                $noreg = GeneratorHelper::generateNoreg($complaintcodeformat['Jumlah Huruf Acak'], $complaintcodeformat['Tanda Pisah']);
                $cek_noreg = Formulirpengaduan::active()->where('f_noreg',$noreg)->get();
            } while($cek_noreg == null);

            $status = Status::active()->where('s_urutan', 1)->first();

            $data = [
                'f_noreg' => $noreg,
                'f_token' => rand(1000,9999),
                'f_nama' => $request->f_nama ? $request->f_nama : 'Anonim ',
                'f_tanggal_masuk' => date('Y-m-d'),
                'f_no_telepon' => $request->f_no_telepon,
                'f_email' => $request->f_email,
                'f_waktu_kejadian' => $request->f_waktu_kejadian,
                'f_tempat_kejadian' => $request->f_tempat_kejadian,
                's_id' => $status->s_id,
                'f_kronologi' => $request->f_kronologi,
                'f_sumber' => 'Web Form',
                'created_by' => $request->f_nama ? $request->f_nama : 'Anonim '.$noreg.'/'. date('Y'),
                'updated_by' => $request->f_nama ? $request->f_nama : 'Anonim '.$noreg.'/'. date('Y'),
            ];

            $formulirpengaduan =  Formulirpengaduan::create($data);

            if($request->hasFile('fb_file_bukti')){
                $files = $request->file('fb_file_bukti');
                foreach($files as $index => $file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = $noreg . "-" . date('Y') . "/Bukti_" . ($index+1) . "_" . time() . "." . $extension;
                    Storage::disk('report')->put($filename,  File::get($file));
                    $databukti = [
                        'f_id' => $formulirpengaduan->f_id,
                        'fb_file_bukti' => $filename,
                        'created_by' => $request->f_nama ? $request->f_nama : 'Anonim ' . $noreg . '/' . date('Y'),
                        'updated_by' => $request->f_nama ? $request->f_nama : 'Anonim ' . $noreg . '/' . date('Y'),
                    ];
                    FormulirpengaduanBukti::create($databukti);
                }
            }

            $datariwayat = [
                'f_id' => $formulirpengaduan->f_id,
                'fr_tanggal' => date('Y-m-d'),
                'fr_status' => $status->s_nama,
                'fr_keterangan' => $status->s_deskripsi,
                'created_by' => $request->f_nama ? $request->f_nama : 'Anonim ' . $noreg . '/' . date('Y'),
                'updated_by' => $request->f_nama ? $request->f_nama : 'Anonim ' . $noreg . '/' . date('Y'),
            ];

            FormulirpengaduanRiwayat::create($datariwayat);

            DB::commit();

            if ($request->f_email) {
                Mail::to($request->f_email)->send(new ComplaintNotification($formulirpengaduan));
            }

            $url = $this->checkaction('inforeport',$formulirpengaduan->f_id);
            return redirect($url);
        }
        catch(\Exception $e){
            DB::rollBack();
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('createreport')->withInput($request->all());
        }
    }

    /**
     * fungsi ini untuk menampilkan registrasi laporan dan token
     *
     * @param  mixed $id
     * @return void
     */
    public function inforeport(Request $request,$id)
    {
        try {
            $cms = CMS::active()->where('cms_halaman', 'Info Pengaduan')->pluck('cms_konten', 'cms_label');
            $searchid = Crypt::decrypt($id);
            $datareport = Formulirpengaduan::active()->where('f_id',$searchid)->first();
            $report = json_decode(json_encode([
                'f_noreg' => $datareport->f_noreg,
                'f_token' => $datareport->f_token,
            ]));

            return view('front.inforeport', compact('report', 'cms'));
        }
        catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('createreport');
        }
    }

    /**
     * fungsi ini untuk memproses pencarian laporan
     *
     * @param  mixed $request
     * @return void
     */
    public function tracereport(Request $request){
        try {
            $datareport = Formulirpengaduan::active()->where('f_noreg',$request->f_noreg_search)->first();

            if($datareport){
                $url = URL::temporarySignedRoute('tracingreport', now()->addHour(), [
                    'id' => Crypt::encrypt($datareport->f_id),
                ]);
                 return redirect($url);
            }
            else{
                 Alert::warning('Gagal', 'Nomor Registrasi tidak ditemukan!');
                 return redirect()->route('index');
            }
        }
        catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('index');
        }
    }

    /**
     * fungsi ini untuk menampilkan halaman lacak laporan
     *
     * @param  mixed $id
     * @return void
     */
    public function tracingreport($id){
        try {
            $cms = CMS::active()->where('cms_halaman', 'Status Pengaduan')->pluck('cms_konten', 'cms_label');
            $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');
            $searchid = Crypt::decrypt($id);
            $report = Formulirpengaduan::find($searchid);

            return view('front.tracingreport', compact('report', 'cms', 'filesizelimit'));
        }
        catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('index');
        }
    }

    /**
     * fungsi ini untuk menambah file bukti tambahan
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function uploadevidence(Request $request,$id){
        $uploadid = Crypt::decrypt($id);
        $datareport = Formulirpengaduan::find($uploadid);

        $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');

        $rules = [
            'fb_file_bukti.0' => 'required',
            'fb_file_bukti.*' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,gif,jpeg,png,mp4.mpeg,mp3,mkv,ogg|max:'.$filesizelimit,
        ];

        $attributes = [
            'fb_file_bukti.0' => 'File bukti',
            'fb_file_bukti.*' => 'File bukti',
        ];

        $rules_message = [
            'required' => ':attribute wajib diisi!',
            'mimes' => 'Format :attribute tidak diizinkan!',
            'max' => 'Ukuran :attribute maksimal ' . $filesizelimit . ' kb!',
        ];

        $validator = Validator::make($request->all(), $rules, $rules_message, $attributes);
        if ($validator->fails()) {
            Alert::warning('Gagal', $validator->errors()->first());
            return redirect()->back();
        }

        try{
            DB::beginTransaction();

            $noreg = explode('/',$datareport['f_noreg']);
            if($request->hasFile('fb_file_bukti')){
                $files = $request->file('fb_file_bukti');
                foreach($files as $index => $file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = $noreg[0]."-".date('Y')."/Bukti_Tambahan_". ($index+1) ."_". time() . "." . $extension;
                    Storage::disk('report')->put($filename,  File::get($file));
                    $databukti=[
                        'f_id' => $uploadid,
                        'fb_file_bukti' =>  $filename,
                        'fb_keterangan' =>  $request->fb_keterangan,
                        'fb_status' =>  'Bukti Tambahan',
                        'created_by' => $datareport->f_nama ? $datareport->f_nama : 'Anonim '.$datareport['f_noreg'].' / '. date('Y'),
                        'updated_by' => $datareport->f_nama ? $datareport->f_nama : 'Anonim '.$datareport['f_noreg'].' / '. date('Y'),
                        'is_active' => 1,
                    ];
                    FormulirpengaduanBukti::create($databukti);
                }
            }

            $status = Status::active()->where('s_urutan', 1)->first();
            $datareport->update([
                's_id' => $status->s_id,
                'updated_by' => $datareport->f_nama ? $datareport->f_nama : 'Anonim '.$datareport['f_noreg'].' / '. date('Y'),
            ]);

            $data_riwayat = [
                'fr_tanggal' => date('Y-m-d'),
                'f_id' => $uploadid,
                'fr_status' => $status->s_nama,
                'fr_keterangan' => $status->s_deskripsi,
                'created_by' => $datareport->f_nama ? $datareport->f_nama : 'Anonim '.$datareport['f_noreg'].' / '. date('Y'),
                'updated_by' => $datareport->f_nama ? $datareport->f_nama : 'Anonim '.$datareport['f_noreg'].' / '. date('Y'),
            ];
            FormulirpengaduanRiwayat::create($data_riwayat);

            DB::commit();
            Alert::success('Sukses','Berhasil unggah bukti!');
            $url = $this->checkaction('tracingreport',$uploadid);
            return redirect($url)->with('success', 'Sukses');
        }
        catch(\Exception $e){
            DB::rollBack();
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('tracingreport',$uploadid);
        }
    }


    /**
     * fungsi ini untuk memverifikasi token
     *
     * @param  mixed $data
     * @return void
     */
    public function tokenverification(Request $request){
        try{
            $report = Formulirpengaduan::active()->where('f_noreg',$request->f_noreg)->whereEncrypted('f_token', $request->f_token)->first();
            if($report){
                Session::put('token', $request->f_token);
                $url = $this->checkaction($request->action,$report->f_id);
                $data = [
                    'result' => true,
                    'message' => 'Token valid',
                    'data' => [
                      'id' =>Crypt::encrypt($report->f_id),
                      'url' => $url
                    ],
                ];

                return $data;
            }else{
                return [
                    'result' => false,
                    'message' => 'Token tidak valid',
                    'data' => ''
                ];
            }
        }catch(\Exception $e){
            return [
                'result' => false,
                'message' => 'Kesalahan',
                'data' => $e->getMessage()
            ];
        }
    }


    /**
     * fungsi ini digunakan untuk mengecek session laporan
     *
     * @return void
     */
    public function checksessionreport(Request $request){
        if($request->ajax()){
            if(session()->has('token')){
                $data = [
                    'success' => true,
                    'data' => session('token'),
                ];
            }else{
                $data = [
                    'success' => false,
                    'data' => '',
                ];
            }
            return $data;
        }
    }


    /**
     * cek action request
     *
     * @param  mixed $action
     * @param  mixed $id
     * @return void
     */
    public function checkaction($action,$id)
    {
        $url= route($action,Crypt::encrypt($id));

        return $url;
    }

    /**
     * fungsi ini menampilkan detail laporan dengan parameter id
     *
     * @param  mixed $id
     * @return void
     */
    public function detailreport(Request $request,$id){
        try {
            if(!session()->has('token')){
                Alert::error('Gagal','Sesi anda telah habis');
                return redirect()->route('index');
            }
            $cms = CMS::active()->where('cms_halaman', 'Detail Pengaduan')->pluck('cms_konten', 'cms_label');

            $report = Formulirpengaduan::find(Crypt::decrypt($id));

            if (!$report) {
                Alert::error('Gagal', 'Laporan tidak ditemukan!');
                return redirect()->route('index');
            }

            return view('front.detailreport', compact('report', 'cms'));
        }
        catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('index');
        }
    }

    /**
     * fungsi ini menampilkan halaman riwayat hasil laporan dengan parameter id
     *
     * @param  mixed $id
     * @return void
     */
    public function resultreport(Request $request,$id){
        try {
            if(!session()->has('token')){
                Alert::error('Gagal','Sesi anda telah habis');
                return redirect()->route('index');
            }
            $cms = CMS::active()->where('cms_halaman', 'Hasil Pengaduan')->pluck('cms_konten', 'cms_label');

            $report = Formulirpengaduan::find(Crypt::decrypt($id));
            if (!$report) {
                Alert::error('Gagal', 'Laporan tidak ditemukan!');
                return redirect()->route('index');
            }
            $historyreport = FormulirpengaduanRiwayat::active()->where('f_id',Crypt::decrypt($id))->orderby('created_at','DESC')->get();

            return view('front.resultreport', compact('report', 'historyreport', 'cms'));
        }
        catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('index');
        }
    }

    /**
     * fungsi ini menampilkan halaman tanya tim dengan parameter id
     *
     * @param  mixed $id
     * @return void
     */
    public function askquestion(Request $request,$id){
        try {
            if(!session()->has('token')){
                Alert::error('Gagal','Sesi anda telah habis');
                return redirect()->route('index');
            }
            $cms = CMS::active()->where('cms_halaman', 'Tanya Tim')->pluck('cms_konten', 'cms_label');
            $report = Formulirpengaduan::find(Crypt::decrypt($id));

            if (!$report) {
                Alert::error('Gagal', 'Laporan tidak ditemukan!');
                return redirect()->route('index');
            }

            $messages = RuangDiskusi::active()->where('rd_noreg',$report->f_noreg)->orderby('created_at','DESC')->get();
            return view('front.askquestion', compact('report', 'messages', 'cms'));
        }
        catch (\Exception $e) {
            return $e->getMessage();
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('index');
        }
    }

    /**
     * fungsi ini untuk mengirim pesan ke tim investigator
     *
     * @param  mixed $request
     * @return void
     */
    public function sentaskquestion(Request $request,$id)
    {
        if(!session()->has('token')){
            Alert::error('Gagal','Pesan tidak dapat dikirim karena sesi anda telah habis');
            return redirect()->route('index');
        }
        $searchid = Crypt::decrypt($id);
        $report = Formulirpengaduan::find($searchid);
        try{
            DB::beginTransaction();

            $subject_exist = Diskusi::active()->where('d_noreg',$report->f_noreg)->first();

            if($subject_exist){
                $datasubject = [
                    'd_waktu' => date('Y-m-d H:i:s'),
                    'd_status' => 'Belum dijawab',
                    'updated_by' => $report->f_nama ? $report->f_nama : 'Anonim '.$report->f_noreg,
                    'is_active' => 1,
                ];

                $subject = Diskusi::find($subject_exist->d_id);
                $subject->update($datasubject);

            }else{
                $datasubject = [
                    'd_noreg' => $report->f_noreg,
                    'd_nama' => $report->f_nama ? $report->f_nama : 'Anonim '.$report->f_noreg,
                    'd_waktu' => date('Y-m-d H:i:s'),
                    'd_status' => 'Belum dijawab',
                    'created_by' => $report->f_nama ? $report->f_nama : 'Anonim '.$report->f_noreg ,
                    'updated_by' => $report->f_nama ? $report->f_nama : 'Anonim '.$report->f_noreg,
                    'is_active' => 1,
                ];

                $subject = Diskusi::create($datasubject);
            }

            $datamessage = [
                'd_id' => $subject->d_id,
                'rd_tipe_user' => 'PELAPOR',
                'rd_noreg' => $report->f_noreg,
                'rd_pesan' => $request->question,
                'created_by' => $report->f_nama ? $report->f_nama : 'Anonim '.$report->f_noreg ,
                'updated_by' => $report->f_nama ? $report->f_nama : 'Anonim '.$report->f_noreg,
                'is_active' => 1,
            ];

            RuangDiskusi::create($datamessage);
            DB::commit();
            $url = $this->checkaction('askquestion',$searchid);
            return redirect($url);

        }catch(\Exception $e){
            DB::rollBack();
            Alert::error('Gagal',$e->getMessage());
            return redirect()->route('index');

        }
    }
}
