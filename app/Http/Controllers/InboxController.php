<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Pesanemail;
use App\Models\FormulirpengaduanRiwayat;
use App\Models\FormulirpengaduanBukti;
use App\Models\Formulirpengaduan;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpImap\Exceptions\ConnectionException;
use PhpImap\Mailbox;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\GeneratorHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplaintNotification;
use DB;

class InboxController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman list data pengaduan via email.
     *
     * @return view
     */
    public function index(){
        if (auth()->user()->can('View Complaint')) {
            $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');
            $currentemail = Pengaturan::active()->where(['pgtr_nama' => 'Email', 'pgtr_label' => 'Konfigurasi IMAP Email'])->value('pgtr_nilai');
            
            return view('dashboard.inbox.index', compact('filesizelimit', 'currentemail'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Pengaduan!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan membaca pengaduan via email di database.
     *
     * @param Request $request
     * @return json $result
     */
    public function reademail(Request $request) {
        try {
            $data = Pesanemail::active()->orderBy('pe_date', 'DESC')->paginate(10);

            if (count($data) > 0) {
                $result = [
                    'success' => true,
                    'message' => "Pesan ditemukan!",
                    'totaldata' => $data->total(),
                    'nextpageurl' => $data->nextPageUrl(),
                    'prevpageurl' => $data->previousPageUrl(),
                    'startpage' => $data->firstItem(),
                    'endpage' => $data->lastItem(),
                    'data' => $data->items()
                ];
            } 
            else {
                $result = [
                    'success' => true,
                    'message' => "Pesan tidak ditemukan!",
                    'totaldata' => $data->total(),
                    'nextpageurl' => $data->nextPageUrl(),
                    'prevpageurl' => $data->previousPageUrl(),
                    'startpage' => $data->firstItem(),
                    'endpage' => $data->lastItem(),
                    'data' => $data->items()
                ];
            }
        } 
        catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    /**
     * * Fungsi ini akan membaca rincian pengaduan via email berdasarkan nomor pesan di database.
     *
     * @param Request $request
     * @return json $result
     */
    public function detailemail(Request $request, $msgno) {
        try {
            $data = Pesanemail::active()->where('pe_msgno', $msgno)->first();

            $result = [
                'success' => true,
                'message' => "Pesan ditemukan!",
                'data' => $data
            ];
        } 
        catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    /**
     * * Fungsi ini akan melakukan sinkronisasi dengan inbox email via IMAP.
     *
     * @return redirect
     */
    public function synchronize() {
        // Tambah waktu eksekusi menjadi 5 menit (default 30 detik)
        ini_set('max_execution_time', '600');

        try {
            $imapSetting = Pengaturan::active()->where('pgtr_label', 'Konfigurasi IMAP Email')->pluck('pgtr_nilai', 'pgtr_nama');
            
            $mailbox = new Mailbox(
                $imapSetting['IMAP'], // IMAP server and mailbox folder
                $imapSetting['Email'], // Email
                $imapSetting['Password'], // Password
                public_path($imapSetting['Direktori']), // Directory where attachments will be saved (optional)
                $imapSetting['Encoding'], // Server encoding (optional)
                true, // Trim leading/ending whitespaces of IMAP path (optional)
                (bool) $imapSetting['Mode'] // Attachment filename mode (optional; false = random filename; true = original filename)
            );
            
            $startdate = Carbon::create(date('Y'), date('m'))->startOfMonth()->format('d M Y'); 
            $enddate = Carbon::create(date('Y'), date('m'))->endOfMonth()->addDay()->format('d M Y');

            DB::beginTransaction();

            $mail_ids = $mailbox->searchMailbox('SINCE "'.$startdate.'" BEFORE "'.$enddate.'"');
            foreach($mail_ids as $index => $mail_id) {
                $mail = $mailbox->getMail($mail_id);

                $mail_exist = Pesanemail::where('pe_msgno', $mail->id)->first();

                if($mail_exist){
                    $data = [
                        'pe_subject'  => $mail->subject,
                        'pe_date' => $mail->date,
                        'pe_udate' => $mail->date,
                        'pe_fromaddress' => $mail->fromAddress,
                        'pe_fromname' => $mail->fromName,
                        'pe_msgno' => $mail->id,
                        'pe_messagebody' => $mail->textHtml,
                        'created_by' => $mail->fromName,
                        'updated_by' => $mail->fromName,
                        'is_active' => 1
                    ];
                    $mail_exist->update($data);
                }
                else {
                    $data = [
                        'pe_subject'  => $mail->subject,
                        'pe_date' => $mail->date,
                        'pe_udate' => $mail->date,
                        'pe_fromaddress' => $mail->fromAddress,
                        'pe_fromname' => $mail->fromName,
                        'pe_msgno' => $mail->id,
                        'pe_messagebody' => $mail->textHtml,
                        'created_by' => $mail->fromName,
                        'updated_by' => $mail->fromName,
                    ];
    
                    $attachments = $mail->getAttachments();
                    $data['pe_attachment'] = "";
                    if ($attachments) {
                        foreach($attachments as $key => $attachment){
                            if($data['pe_attachment'] == ""){
                                $data['pe_attachment'] = $attachment->name;
                            }
                            else{
                                $data['pe_attachment'] = $data['pe_attachment'].";".$attachment->name;
                            }
                        }
                    }

                    Pesanemail::create($data);
                }
            }
            
            DB::commit();
            Alert::success('Sukses', 'Email berhasil disinkronkan!');
            return redirect()->route('inbox.index');

        }
        catch(Exception $e) {
            Alert::error('Gagal',"IMAP connection failed: " . implode(",", $e->getErrors('all')));
            return redirect()->route('inbox.index');
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
        $complaintcodeformat = Pengaturan::active()->where('pgtr_label', 'Format Nomor Laporan')->pluck('pgtr_nilai', 'pgtr_nama');

        $rules = [
            'f_waktu_kejadian' => 'required',
            'f_tempat_kejadian' => 'required',
            'f_kronologi' => 'required',
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
        ];

        $rules_message = [
            'required' => ':attribute wajib diisi!', 
            'email' => 'Format :attribute tidak sesuai standar!',
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
                'f_sumber' => 'Email',
                'created_by' => $request->f_nama ? $request->f_nama : 'Anonim '.$noreg.'/'. date('Y'),
                'updated_by' => $request->f_nama ? $request->f_nama : 'Anonim '.$noreg.'/'. date('Y'),
            ];

            $formulirpengaduan =  Formulirpengaduan::create($data);
    
            if ($request->f_bukti) {
                $attachments = explode(',', $request->f_bukti);
                foreach ($attachments as $attachment){
                    $databukti = [
                        'f_id' => $formulirpengaduan->f_id, 
                        'fb_file_bukti' => $attachment,
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
            Pesanemail::active()->where('pe_msgno',$request->msgno)->update(['is_generate_report'=>1]);
            DB::commit();

            if ($formulirpengaduan->f_email) {
                Mail::to($formulirpengaduan->f_email)->send(new ComplaintNotification($formulirpengaduan));
            }

            Alert::success('Sukses', 'Data berhasil ditambahkan!');
            return redirect()->route('inbox.index');
        }
        catch(\Exception $e){
            DB::rollBack();
            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('inbox.index');
        }
    }
}
