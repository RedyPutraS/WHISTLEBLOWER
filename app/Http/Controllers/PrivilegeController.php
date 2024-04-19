<?php

namespace App\Http\Controllers;

use App\Utils\Datatable;
use Illuminate\Http\Request;
use App\Models\Privilege;
use App\Models\PrivilegeGroup;
use RealRashid\SweetAlert\Facades\Alert;

class PrivilegeController extends BaseController
{
   /**
     * * Fungsi ini akan menampilkan halaman list data privilege.
     *
     * @return view
     */
    public function index()
    {
        if (auth()->user()->can('View Privilege')) {
            $privilegegroups = PrivilegeGroup::active()->get();

            return view('dashboard.privilege.index', compact('privilegegroups'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Privilege!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menampilkan halaman tambah data privilege.
     *
     * @return view
     */
    public function create()
    {
        if (auth()->user()->can('Add Privilege')) {
            return view('dashboard.privilege.create');
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menambah Privilege!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menambahkan data privilege ke database.
     *
     * @param Request $request
     * @return redirect to view with message
     */
    public function store(Request $request)
    {
        if (auth()->user()->can('Add Privilege')) {
            $rules = [
                'p_namas' => 'required',
                'pg_nama' => 'required',
            ];

            $rulesMessages = [
                'required' => ':attribute wajib diisi!',
            ];

            $attributes = [
                'pg_nama' => 'Nama privilege',
                'p_namas' => 'Isi privilege',
            ];

            $this->validate($request, $rules, $rulesMessages, $attributes);

            $data = [
                'pg_nama' => $request->pg_nama,
                'created_by' => auth()->user()->u_nama,
                'is_active' => 1
            ];

            $privilegegroup = PrivilegeGroup::create($data);
    
            foreach ($request->p_namas as $privilege) {
                $data_privilege = [
                    'p_nama' => $privilege,
                    'pg_id' => $privilegegroup->pg_id,
                    'is_active' => 1
                ];
                $privilege = Privilege::create($data_privilege);
            }
    
            return redirect()->route('privilege.index')->with('success', 'Data berhasil disimpan!');
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menambah Privilege!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menampilkan halaman ubah data privilege.
     *
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        if (auth()->user()->can('Edit Privilege')) {
            $privilegegroup = PrivilegeGroup::find($id);
            return view('dashboard.privilege.edit', compact('privilegegroup'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Privilege!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan mengubah data privilege di database.
     *
     * @param Request $request
     * @param int $id
     * @return redirect to view with message
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->can('Edit Privilege')) {
            $rules = [
                'pg_nama' => 'required',
                'p_namas' => 'required'
            ];

            $rulesMessages = [
                'required' => ':attribute wajib diisi!',
            ];

            $attributes = [
                'pg_nama' => 'Nama privilege',
                'p_namas' => 'Isi privilege',
            ];

            $this->validate($request, $rules, $rulesMessages, $attributes);
    
            $privilegegroup = PrivilegeGroup::find($id);
            $data = [
                'pg_nama' => $request->pg_nama,
                'updated_by' => auth()->user()->u_nama,
                'is_active' => 1
            ];
    
            $privilegegroup->privilege()->whereNotIn('p_nama', $request->p_namas)->update([
                'is_active' => 0
            ]);
            $privilegegroup->privilege()->whereIn('p_nama', $request->p_namas)->update([
                'is_active' => 1
            ]);
    
            $privilegegroup->update($data);
    
            $p_nama_exists = $privilegegroup->privilege()->whereIn('p_nama', $request->p_namas)->pluck('p_nama')->toArray();
    
            foreach ($request->p_namas as $p_nama) {
                if (!in_array($p_nama, $p_nama_exists)) {
                    $data_privilege = [
                        'p_nama' => $p_nama,
                        'pg_id' => $privilegegroup->pg_id,
                        'is_active' => 1
                    ];
                    $privilege = Privilege::create($data_privilege);
                }
                else {
                    $data_privilege = [
                        'p_nama' => $p_nama,
                        'updated_by' => auth()->user()->nama,
                        'is_active' => 1
                    ];
                    $privilege = Privilege::where('p_nama', $p_nama)->where('pg_id', $privilegegroup->id)->update($data_privilege);
                }
            }
    
            return redirect()->route('privilege.index')->with('success', 'Data berhasil diubah!');
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Privilege!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menghapus data privilege dari database.
     *
     * @param int $id
     * @return json
     */
    public function destroy($id)
    {
        if (auth()->user()->can('Delete Privilege')) {
            $privilegegroup = PrivilegeGroup::find($id);
            
            $data = [
                'is_active' => 0,
                'updated_by' => auth()->user()->u_nama,
            ];
            $response = $privilegegroup->update($data);

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
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menghapus Privilege!');
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
            "querytarget" => \App\Model\PrivilegeGroup::class,
            "with" => ['privilege'],
        ];
        $result = new Datatable($request, $params);

        return $result->getdatatable();
    }
}
