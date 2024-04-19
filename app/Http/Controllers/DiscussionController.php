<?php

namespace App\Http\Controllers;

use App\Models\Diskusi;
use App\Models\Formulirpengaduan;
use App\Models\RuangDiskusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseHelper;
use App\Mail\FeedbackNotification;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;

class DiscussionController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman list data pertanyaan.
     *
     * @return view
     */
    public function index()
    {
        if (auth()->user()->can('View Discussion')) {

            $discussions = Diskusi::active()->orderBy('created_at', 'DESC')->get();

            return view('dashboard.discussion.index', compact('discussions'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Pertanyaan!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan membalas pertanyaan.
     *
     * @param Request $request
     * @param integer $id
     * @return redirect to view with message
     */
    public function reply(Request $request, $id)
    {
        if(auth()->user()->can('Add Discussion')) {
            if($request->ajax()) {
                $discussion_id = Crypt::decrypt($id);
                $subject = Diskusi::find($discussion_id);
                try{
                    DB::beginTransaction();
    
                    $datasubject = [
                        'd_waktu' => date('Y-m-d H:i:s'),
                        'd_status' => 'Dijawab oleh Tim Investigasi', 
                        'updated_by' => $subject->f_nama ? $subject->f_nama : 'Tim Investigasi '.$subject->d_noreg, 
                        'is_active' => 1,
                    ];
                    
                    $subject->update($datasubject);
    
                    $datamessage = [
                        'd_id' => $subject->d_id,
                        'rd_tipe_user' => 'TIM INVESTIGASI',
                        'rd_noreg' => $subject->d_noreg,
                        'rd_pesan' => $request->rd_pesan,
                        'created_by' => 'Tim Investigasi '.$subject->d_noreg, 
                        'updated_by' => 'Tim Investigasi '.$subject->d_noreg, 
                        'is_active' => 1, 
                    ];
    
                    RuangDiskusi::create($datamessage);
                    $report = Formulirpengaduan::active()->where('f_noreg',$subject->d_noreg)->first();
                    if($report->f_email){
                        $messagedata = [
                            'email' => $report->f_email,
                            'noreg' => $report->f_noreg,
                            'message' => $request->rd_pesan
                        ];
                        $this->feedbacknotification($messagedata);
                    }
                    DB::commit();
                    $data = [
                        'id' => $id
                    ];
                    $response = ResponseHelper::response(true,'Pesan berhasil dikirim',$data);
                    
                    return $response;
                }
                catch(\Exception $e){
                    DB::rollBack();
                    $response = ResponseHelper::response(false,$e->getMessage());
                    return $response;
                }
            }
        }
        else {
            $response = ResponseHelper::response(true,'Anda tidak memiliki akses untuk membalas pesan');
            return $response;
        }
    }

    public function feedbacknotification(array $messagedata=null){
        $complaint = Formulirpengaduan::active()->where('f_noreg', $messagedata['noreg'])->first();
        $message = new stdClass();
        $complaint->message_created_by = 'Tim Investigasi';
        $complaint->message_created_at = date('Y-m-d H:i:s');
        $complaint->message_rd_pesan = $messagedata['message'];
    
        Mail::to($messagedata['email'])->send(new FeedbackNotification($complaint));
    }

    public function getdiscussion(Request $request,$id){
        if(auth()->user()->can('View Discussion')){
            if($request->ajax()){
                try{
                    $discussions_id = Crypt::decrypt($id);
                    $chat = RuangDiskusi::active()->where('d_id',$discussions_id)->orderby('created_at','DESC')->get();
                    $noreg = RuangDiskusi::active()->groupby('rd_noreg')->pluck('rd_noreg');
                    $response = [
                        'success' => true,
                        'message' => 'Ruang Diskusi ditemukan',
                        'data' => [
                            'id' => $id,
                            'noreg' => $noreg,
                            'discussion' => $chat,
                        ]
                    ];
                    return $response;
                }
                catch(\Exception $e){
                    $response = [
                        'success' => false,
                        'message' => 'Not Found',
                        'data' => $e->getMessage()
                    ];
                    return $response;
                }
            }
            else{
                return response()->view('errors.custom', [], 500);
            }
        }
    }
}
