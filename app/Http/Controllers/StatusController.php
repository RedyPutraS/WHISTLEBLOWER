<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class StatusController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman list data status.
     *
     * @return view
     */
    public function index()
    {
        if (auth()->user()->can('View Status')) {
            try {
                $statuses = Status::active()->orderBy('s_urutan')->get();
    
                return view('dashboard.status.index', compact('statuses'));
            } 
            catch (\Exception $e) {
                Alert::warning('Gagal', $e->getMessage());

                return redirect()->route('dashboard');
            }
        } 
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Data Master Status!');
            return redirect()->route('dashboard');
        }        
    }

    /**
     * * Fungsi ini akan menambahkan data status ke database.
     *
     * @param Request $request
     * @return redirect to view with message
     */
    public function store(Request $request)
    {
        if (auth()->user()->can('Add Status')) {
            $rules = [
                's_nama' => 'required',
                's_warna_background' => 'required',
                's_warna_teks' => 'required',
                's_urutan' => 'required',
                's_deskripsi' => 'required',
            ];

            $rulesMessages = [
                'required' => ':attribute wajib diisi!',
            ];

            $attributes = [
                's_nama' => 'Nama status',
                's_warna_background' => 'Warna background untuk status',
                's_warna_teks' => 'Warna teks untuk status',
                's_urutan' => 'Urutan dalam tahapan',
                's_deskripsi' => 'Deskripsi',
            ];

            $this->validate($request, $rules, $rulesMessages, $attributes);

            try {
                $data = [
                    's_nama' => $request->s_nama,
                    's_warna_background' => $request->s_warna_background,
                    's_warna_teks' => $request->s_warna_teks,
                    's_urutan' => $request->s_urutan,
                    's_deskripsi' => $request->s_deskripsi,
                    's_label' => $request->s_label,
                    's_keterangan' => $request->s_keterangan,
                    'is_active' => 1
                ];
    
                Status::create($data);
        
                return redirect()->route('status.index')->with('success', 'Data berhasil disimpan!');
            }
            catch (\Exception $e) {
                Alert::warning('Gagal', $e->getMessage());

                return redirect()->route('status.index');
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menambah Data Master Status!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan mengubah data status di database.
     *
     * @param Request $request
     * @return redirect to view with message
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->can('Edit Status')) {
            $rules = [
                's_nama' => 'required',
                's_warna_background' => 'required',
                's_warna_teks' => 'required',
                's_urutan' => 'required',
                's_deskripsi' => 'required',
            ];

            $rulesMessages = [
                'required' => ':attribute wajib diisi!',
            ];

            $attributes = [
                's_nama' => 'Nama status',
                's_warna_background' => 'Warna background untuk status',
                's_warna_teks' => 'Warna teks untuk status',
                's_urutan' => 'Urutan dalam tahapan',
                's_deskripsi' => 'Deskripsi',
            ];

            $this->validate($request, $rules, $rulesMessages, $attributes);

            try {
                $status = Status::find(Crypt::decrypt($id));

                $data = [
                    's_nama' => $request->s_nama,
                    's_warna_background' => $request->s_warna_background,
                    's_warna_teks' => $request->s_warna_teks,
                    's_urutan' => $request->s_urutan,
                    's_deskripsi' => $request->s_deskripsi,
                    's_label' => $request->s_label,
                    's_keterangan' => $request->s_keterangan,
                    'is_active' => 1
                ];
    
                $status->update($data);
        
                return redirect()->route('status.index')->with('success', 'Data berhasil diubah!');
            }
            catch (\Exception $e) {
                Alert::warning('Gagal', $e->getMessage());

                return redirect()->route('status.index');
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Data Master Status!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menghapus data status dari database.
     *
     * @param int $id
     * @return json
     */
    public function destroy($id)
    {
        if (auth()->user()->can('Delete Status')) {
            try {
                $status = Status::find(Crypt::decrypt($id));
                
                $data = [
                    'is_active' => 0,
                    'updated_by' => auth()->user()->u_nama,
                ];
                $response = $status->update($data);
    
                if ($response) {
                    return json_encode([
                        'success' => true,
                        'status' => 200,
                        'message' => "Data berhasil dihapus!",
                    ]);
                }
                else {
                    return json_encode([
                        'success' => false,
                        'status' => 400,
                        'message' => "Data gagal dihapus!",
                    ]);
                }
            }
            catch (\Exception $e) {
                return json_encode([
                    'success' => false,
                    'status' => 400,
                    'message' => $e->getMessage(),
                ]);
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menghapus Data Master Status!');
            return redirect()->route('dashboard');
        }
    }

    public function getdata($id)
    {
        try {
            $data = Status::find(Crypt::decrypt($id));
            $response = [
                'success' => true,
                'message' => 'Sukses',
                'data' => $data,
            ];

            return $response;
        } 
        catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ];

            return $response;
        }
    }
}
