<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\PrivilegeGroup;
use App\Models\Role;
use App\Models\RolePrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman list data role.
     *
     * @return view
     */
    public function index()
    {
        // if (auth()->user()->can('View Role')) {
            $roles = Role::active()->get();

            return view('dashboard.role.index', compact('roles'));
        // }
        // else {
        //     Alert::warning('Gagal', 'Anda tidak memiliki akses melihat Role!');
        //     return redirect()->route('dashboard');
        // }
    }

    /**
     * * Fungsi ini akan menampilkan halaman tambah data role.
     *
     * @return view
     */
    public function create()
    {
        if (auth()->user()->can('Add Role')) {
            $privilegegroups = PrivilegeGroup::active()->with('privilege')->get();
            $privilege_lists = Privilege::select('p_nama')->groupby('p_nama')->get();
        
            return view('dashboard.role.create', compact('privilegegroups', 'privilege_lists'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menambah Role!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menambahkan data role ke database.
     *
     * @param Request $request
     * @return redirect to view with message
     */
    public function store(Request $request)
    {
        if (auth()->user()->can('Add Role')) {
            $rules = [
                'r_nama' => 'required',
                'p_ids' => 'array|min:1',
            ];
    
            $rulesMessages = [
                'required' => ':attribute wajib diisi!',
                'array' => ':attribute wajib diisi!',
                'min' => ':attribute wajib dipilih minimal 1!',
            ];

            $attributes = [
                'r_nama' => 'Nama role',
                'p_ids' => 'Akses privilege',
            ];

            $this->validate($request, $rules, $rulesMessages, $attributes);

            DB::beginTransaction();

            $data = [
                'r_nama' => $request->r_nama,
                'created_by' => auth()->user()->u_nama,
                'updated_by' => auth()->user()->u_nama,
                'is_active' => 1
            ];
            $role = Role::create($data);
    
            if ($request->p_ids) {
                foreach ($request->p_ids as $privilege) {
                    $data_privilege = [
                        'r_id' => $role->r_id,
                        'p_id' => $privilege,
                    ];
                    RolePrivilege::create($data_privilege);
                }

                DB::commit();
                return redirect()->route('role.index')->with('success', 'Data berhasil disimpan!');
            }
            else {
                DB::rollBack();
                return redirect()->back()->withErrors('Wajib memilih privilege minimal 1!')->withInput($request->all());
            }       
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menambah Role!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menampilkan halaman ubah data role.
     *
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        if (auth()->user()->can('Edit Role')) {
            $role = Role::find($id);
            $privilegegroups = PrivilegeGroup::active()->get();
            $privilege_lists = Privilege::select('p_nama')->active()->distinct()->orderBy('p_nama')->get();
            
            return view('dashboard.role.edit', compact('role', 'privilegegroups', 'privilege_lists'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Role!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan mengubah data role di database.
     *
     * @param Request $request
     * @param int $id
     * @return redirect to view with message
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->can('Edit Role')) {
            $rules = [
                'r_nama' => 'required',
                'p_ids' => 'required|array|min:1',
            ];

            $rulesMessages = [
                'required' => ':attribute wajib diisi!',
                'array' => ':attribute wajib diisi!',
                'min' => ':attribute wajib dipilih minimal 1!',
            ];

            $attributes = [
                'r_nama' => 'Nama role',
                'p_ids' => 'Akses privilege',
            ];

            $this->validate($request, $rules, $rulesMessages, $attributes);

            try{
                DB::beginTransaction();
        
                $role = Role::find($id);
        
                $data = [
                    'r_nama' => $request->r_nama,
                    'updated_by' => auth()->user()->u_nama,
                    'is_active' => 1,
                ];
                $role->update($data);
        
                $role->role_privilege()->whereNotIn('p_id', $request->p_ids)->update(['is_active' => 0]);
                // $role->role_privilege()->whereNotIn('p_id', $request->p_ids)->update(['is_active' => 0, 'updated_by' => auth()->user()->u_nama]);
                $privilege_exists = $role->role_privilege()->whereIn('p_id', $request->p_ids)->pluck('p_id')->toArray();
    
                if ($request->p_ids) {
                    foreach ($request->p_ids as $privilege) {
                        if (!in_array($privilege, $privilege_exists)) {
                            $data_privilege = [
                                'r_id' => $role->r_id,
                                'p_id' => $privilege,
                            ];
                            RolePrivilege::create($data_privilege);
                        }
                    }
    
                    DB::commit();
                    return redirect()->route('role.index')->with('success', 'Data berhasil diubah!');
                }
                else {
                    DB::rollBack();
                    return redirect()->back()->withErrors('Wajib memilih privilege minimal 1!')->withInput($request->all());
                }
            }catch(\Exception $e){
                return redirect()->back()->withErrors($e->getMessage());
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah Role!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * * Fungsi ini akan menghapus data role dari database.
     *
     * @param int $id
     * @return json
     */
    public function destroy($id)
    {
        if (auth()->user()->can('Delete Role')) {
            try{
                $role = Role::find($id);
                $data = [
                    'is_active' => 0,
                    'updated_by' => auth()->user()->u_nama,
                ];
                $role->role_privilege()->update($data);
                $response = $role->update($data);
        
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
            }catch(\Exception $e ){
                return json_encode([
                    'success' => false,
                    'status' => 500,
                    'message' => $e->getMessage(),
                ]);
            }
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses menghapus Role!');
            return redirect()->route('dashboard');
        }
    }
}
