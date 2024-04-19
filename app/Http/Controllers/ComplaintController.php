<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Formulirpengaduan;
use App\Models\FormulirpengaduanRiwayat;
use App\Models\FormulirpengaduanBukti;
use App\Models\Status;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use App\Helpers\GeneratorHelper;
use App\Models\Pesanemail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplaintNotification;

class ComplaintController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman list data pertanyaan.
     *
     * @return view
     */
    public function index()
    {
        if (auth()->user()->can('View Complaint')) {
            $complaints = Formulirpengaduan::active()->with('status')->orderBy('created_at', 'DESC')->get();
            $medias = explode(',', Pengaturan::active()->where('pgtr_nama', 'Media Pelapor')->value('pgtr_nilai'));
            $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');
            $expiredday = Pengaturan::active()->where('pgtr_nama', 'Waktu Tindak Lanjut')->value('pgtr_nilai');
            $statuses = Status::active()->get();
            
            return view('dashboard.complaint.index', compact('complaints', 'medias', 'filesizelimit', 'expiredday', 'statuses'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Pengaduan!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan memperbarui hasil penyelidikan. (Memadai/tidak memadai)
     *
     * @param Request $request
     * @param integer $id
     * @return redirect to view with message
     */
    public function initialinvestigation(Request $request, $id)
    {
        if(auth()->user()->can('Edit Complaint')){
            $rules = [
                'fr_status' => 'required',
                'fr_keterangan' => 'required',
            ];
            
            $attributes = [
                'fr_status' => 'Status',
                'fr_keterangan' => 'Keterangan'
            ];

            $rules_message = [
                'required' => ':attribute wajib diisi',
            ];

            $this->validate($request,$rules,$rules_message,$attributes);

            try{
                DB::beginTransaction();

                $form_id = Crypt::decrypt($id);
                $form = Formulirpengaduan::find($form_id);

                $data_riwayat = [
                    'fr_tanggal' => date('Y-m-d'),
                    'f_id' => $form_id
                ];

                if($request->fr_status == 'Memadai') {
                    $status = Status::active()->where('s_urutan', 3)->first();
                    $form->update(
                        [
                            's_id' => $status->s_id,
                            'updated_by' => auth()->user()->u_nama,
                        ]
                    );
                    $data_riwayat['fr_status'] = $status->s_nama;
                    $data_riwayat['fr_keterangan'] = $status->s_deskripsi . " " . $request->fr_keterangan;
                }
                else if($request->fr_status == 'Tidak Memadai'){
                    $status = Status::active()->where('s_urutan', 4)->first();
                    $form->update([
                        's_id' => $status->s_id,
                        'updated_by' => auth()->user()->u_nama,
                    ]);
                    $data_riwayat['fr_status'] = $status->s_nama;
                    $data_riwayat['fr_keterangan'] = $status->s_deskripsi . " " . $request->fr_keterangan;
                }

                FormulirpengaduanRiwayat::create($data_riwayat);

                DB::commit();

                if ($form->f_email) {
                    Mail::to($form->f_email)->send(new ComplaintNotification($form));
                }

                Alert::success('Success','Status pengaduan berhasil diubah!');
                return redirect()->route('complaint.index');

            }
            catch(\Exception $e){
                DB::rollBack();
                Alert::warning('Gagal',$e->getMessage());
                return redirect()->route('complaint.index');
            }
        }
    }

    /**
     * * Fungsi ini akan memperbarui hasil penyidikan. (Terbukti/tidak terbukti)
     *
     * @param Request $request
     * @param integer $id
     * @return redirect to view with message
     */
    public function investigation(Request $request, $id)
    {
        if(auth()->user()->can('Edit Complaint')){
            $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');

            $rules = [
                'fr_status' => 'required',
                'fr_keterangan' => 'required',
                'fr_file_bukti_investigasi' => 'required|mimes:pdf,doc,docx|max:'.$filesizelimit,
            ];
            
            $attributes = [
                'fr_status' => 'Status',
                'fr_keterangan' => 'Keterangan',
                'fr_file_bukti_investigasi' => 'Bukti investigasi'
            ];

            $rules_message = [
                'required' => ':attribute wajib diisi!',
                'mimes' => 'Format :attribute tidak diizinkan!',  
                'max' => 'Ukuran :attribute maksimal ' . $filesizelimit . 'kb!',  
            ];

            $this->validate($request,$rules,$rules_message,$attributes);

            try{                
                DB::beginTransaction();

                $form_id = Crypt::decrypt($id);
                $form = Formulirpengaduan::find($form_id);

                $data_riwayat = [
                    'fr_tanggal' => date('Y-m-d'),
                    'f_id' => $form_id,
                    'created_by' => auth()->user()->u_nama,
                    'updated_by' => auth()->user()->u_nama,
                ];

                $data_bukti = [
                    'f_id' => $form_id,
                    'created_by' => auth()->user()->u_nama,
                    'updated_by' => auth()->user()->u_nama,
                ];

                if($request->fr_status == 'Terbukti'){
                    $status = Status::active()->where('s_urutan', 5)->first();
                    $form->update(
                        [
                            's_id' => $status->s_id,
                            'updated_by' => auth()->user()->u_nama,
                        ]
                    );
                    $data_riwayat['fr_status'] = $status->s_nama;
                    $data_riwayat['fr_keterangan'] = $status->s_deskripsi . " " . $request->fr_keterangan;
                }
                else if($request->fr_status == 'Tidak Terbukti'){
                    $status = Status::active()->where('s_urutan', 6)->first();
                    $form->update([
                        's_id' => $status->s_id,
                        'updated_by' => auth()->user()->u_nama,
                    ]);
                    $data_riwayat['fr_status'] = $status->s_nama;
                    $data_riwayat['fr_keterangan'] = $status->s_deskripsi . " " . $request->fr_keterangan;
                }

                $noreg = str_replace('/','-',$form->f_noreg);
                if($request->hasFile('fr_file_bukti_investigasi')){
                    $file = $request->file('fr_file_bukti_investigasi');
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = $noreg . "/Bukti_Investigasi_" . time() . "." . $extension;
                    Storage::disk('report')->put($filename,  File::get($file));
                    $data_riwayat['fr_file_bukti_investigasi'] = $filename;
                    $data_bukti['fb_file_bukti'] = $filename;
                }

                FormulirpengaduanRiwayat::create($data_riwayat);

                FormulirpengaduanBukti::create($data_bukti);

                DB::commit();

                if ($form->f_email) {
                    Mail::to($form->f_email)->send(new ComplaintNotification($form));
                }

                return redirect()->route('complaint.index')->with('success', 'Data berhasil disimpan!');
            }
            catch(\Exception $e){
                DB::rollBack();
                Alert::warning('Gagal',$e->getMessage());
                return redirect()->route('complaint.index');
            }
        }
    }

    /**
     * * Fungsi ini akan menyimpan data pengaduan ke database.
     *
     * @param Request $request
     * @param integer $id
     * @return redirect to view with message
     */
    public function store(Request $request)
    {
        $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');
        $complaintcodeformat = Pengaturan::active()->where('pgtr_label', 'Format Nomor Laporan')->pluck('pgtr_nilai', 'pgtr_nama');

        $rules = [
            'f_waktu_kejadian' => 'required',
            'f_tempat_kejadian' => 'required',
            'f_kronologi' => 'required',
            'fb_file_bukti.*' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,gif,jpeg,png,mp4.mpeg,mp3,mkv,ogg|max:'.$filesizelimit,
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
            'fb_file_bukti' => 'Bukti',
        ];

        $rules_message = [
            'required' => ':attribute wajib diisi!', 
            'email' => 'Format :attribute tidak sesuai standar!',
            'mimes' => 'Format :attribute tidak diizinkan!',  
            'max' => 'Ukuran :attribute maksimal ' . $filesizelimit . 'kb!',  
        ];

        $this->validate($request,$rules,$rules_message,$attributes);

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
                'f_sumber' => $request->f_sumber, 
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

            if ($formulirpengaduan->f_email) {
                Mail::to($formulirpengaduan->f_email)->send(new ComplaintNotification($formulirpengaduan));
            }

            return redirect()->route('complaint.index')->with('success', 'Data berhasil disimpan!');
        }
        catch(\Exception $e){
            DB::rollBack();
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('complaint.index');
        }
    }

    public function print($id)
    {
        try {
            $complaint = Formulirpengaduan::find(Crypt::decrypt($id));

            return view('dashboard.complaint.print', compact('complaint'));
        } 
        catch (\Exception $e) {
            Alert::warning('Gagal', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * * Fungsi ini akan menampilkan data pengaduan berdasarkan id.
     *
     * @return view
     */
    public function getdata($id)
    {
        $result = Formulirpengaduan::with(['status', 'formulirpengaduan_riwayat', 'formulirpengaduan_bukti', 'diskusi'])->find(Crypt::decrypt($id));
        return response()->json($result);
    }
}
