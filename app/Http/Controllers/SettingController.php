<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;
use Alert;
use Validator;

class SettingController extends BaseController
{
    public function index()
    {
        if (auth()->user()->can('View Setting')) {
            $settings = Pengaturan::active()->byLabel()->get();
            foreach ($settings as $key => $setting) {
                $setting->config = Pengaturan::active()->where('pgtr_label', $setting->pgtr_label)->get();
            }

            return view('dashboard.setting.index', compact('settings'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Pengaturan!');
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request)
    {
        if (auth()->user()->can('Edit Setting')) {
            try {            
                foreach ($request->pgtr_nilai as $key => $pgtr_nilai) {
                    $setting = Pengaturan::findConfig($request->pgtr_id[$key]);
                    $data = [
                        'pgtr_nilai' => $pgtr_nilai
                    ];
            
                    $setting->update($data);
                }
        
                Alert::success('Sukses', 'Data berhasil disimpan!');
                return redirect()->route('setting.index');
            }
            catch (\Exception $e) {
                Alert::warning('Gagal', $e->getMessage());
                return redirect()->route('dashboard');
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Pengaturan!');
            return redirect()->route('dashboard');
        }
    }
}
