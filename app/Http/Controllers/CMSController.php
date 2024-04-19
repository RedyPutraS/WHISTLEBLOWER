<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CMS;
use App\Models\Pengaturan;
use Alert;
use GlobalHelper;
use Validator;
use DB;
use Storage;
use File;

class CMSController extends BaseController
{
    public function index()
    {
        if (auth()->user()->can('View CMS')) {
            $cmses = CMS::active()->byPage()->get();
            foreach ($cmses as $key => $cms) {
                $cms->content = CMS::active()->where('cms_urutan', $cms->cms_urutan)->get();
                $cms->cms_halaman = CMS::active()->select('cms_halaman')->where('cms_urutan', $cms->cms_urutan)->first()->cms_halaman;
            }

            return view('dashboard.cms.index', compact('cmses'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Content Management System!');
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request)
    {
        if (auth()->user()->can('Edit CMS')) {
            try {
                DB::beginTransaction();
                foreach ($request->cms_konten as $key => $cms_konten) {
                    $cms = CMS::findContent($request->cms_id[$key]);
                    if ($cms->cms_input_type == 'file') {
                        $filesizelimit = Pengaturan::active()->where('pgtr_nama', 'Batas Unggah File (kb)')->value('pgtr_nilai');

                        $rules = [
                            'cms_konten_file.'.$key => 'mimes:jpg,jpeg,png|max:' . $filesizelimit,
                        ];

                        $attributes = [
                            'cms_konten_file.'.$key => 'Unggahan Gambar',
                        ];

                        $rules_message = [
                            'mimes' => 'Format :attribute tidak diizinkan!',
                            'max' => 'Ukuran :attribute maksimal ' . $filesizelimit . 'kb!',
                        ];

                        $validator = Validator::make($request->all(), $rules, $rules_message, $attributes);
                        if ($validator->fails()) {
                            DB::rollback();
                            Alert::warning('Gagal', $validator->errors()->first());
                            return redirect()->back();
                        }
                        
                        $data = [
                            'updated_by' => auth()->user()->u_nama,
                        ];

                        if ($cms_konten) {
                            $file = $cms_konten;
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $filename = time() . "." . $extension;
                            if ($cms->cms_konten) {
                                Storage::disk('cms')->delete($cms->cms_konten);
                            }
                            Storage::disk('cms')->put($filename,  File::get($file));
                            $data['cms_konten'] = $filename;
                        }

                        $cms->update($data);
                    }
                    else {
                        $data = [
                            'cms_konten' => $cms_konten,
                            'updated_by' => auth()->user()->u_nama,
                        ];
                
                        $cms->update($data);
                    }
                }

                DB::commit();
                Alert::success('Sukses', 'Data berhasil disimpan!');
                return redirect()->route('cms.index');
            }
            catch (\Exception $e) {
                Alert::warning('Gagal', $e->getMessage());
                return redirect()->route('cms.index');
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Content Management System!');
            return redirect()->route('dashboard');
        }
    }
}
