<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends BaseController
{
    /**
     * * Fungsi ini akan menampilkan halaman list data user.
     *
     * @return view
     */
    public function index()
    {
        if (auth()->user()->can('View User')) {
            $users = User::active()->with('role')->get();
            
            $roles = Role::active()->get();    
            
            return view('dashboard.user.index', compact('users', 'roles'));
        }
        else {
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat User!');
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('Add User')){
            $rules = [
                'u_nama' => 'required',
                'u_username' => 'required|unique:users,u_username',
                'u_email' => 'required|max:255|email:dns,rfc,filter|unique:users,u_email,null,u_id,is_active,1',
                'u_password' => 'required',
                'r_id' => 'required',
            ];

            $rules_message = [
                'required' => 'Kolom :attribute wajib diisi',
                'unique' => ':attribute ini sudah terdaftar'
            ];

            $attribute = [
                'u_nama' => 'Nama',
                'u_username' => 'Username',
                'u_email' => 'Email',
                'u_password' => 'Password',
                'r_id' => 'Role',
            ];

            $this->validate($request,$rules,$rules_message,$attribute);

            try{

                DB::beginTransaction();
                
                $data = [
                    'u_nama' => $request->u_nama,
                    'u_username' => $request->u_username,
                    'u_email' => $request->u_email,
                    'u_password' => Hash::make($request->u_password),
                    'u_password_raw' => $request->u_password,
                    'r_id' => $request->r_id,
                    'created_by' => '',
                    'updated_by' => '',
                    'is_active' => 1,
                ];

                User::create($data);
                DB::commit();
                Alert::success('Sukses','Data berhasil disimpan');
                return redirect()->route('user.index');
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('Gagal',$e->getMessage());
                return redirect()->route('user.index');
            }

        }else{
            Alert::warning('Gagal', 'Anda tidak memiliki akses melihat User!');
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->can('Edit User')){

            $user_id = Crypt::decrypt($id);
            $user = User::find($user_id);
            
            $rules = [
                'u_nama' => 'required',
                'r_id' => 'required',
            ];
    
            $rules_message = [
                'required' => 'Kolom :attribute wajib diisi',
                'unique' => ':attribute ini sudah terdaftar'
            ];
    
            $attribute = [
                'u_nama' => 'Nama',
                'u_username' => 'Username',
                'u_email' => 'Email',
                'r_id' => 'Role',
            ];
    
            $this->validate($request,$rules,$rules_message,$attribute);
    
            try{
    
                DB::beginTransaction();
                
                $data = [
                    'u_nama' => $request->u_nama,
                    'u_username' => $request->u_username,
                    'u_email' => $request->u_email,
                    'r_id' => $request->r_id,
                    'updated_by' => ''
                ];
    
                if($request->u_password != null){
                    $data['u_password'] = bcrypt($request->u_password);
                }
    
                $user->update($data);
                DB::commit();
                Alert::success('Sukses','Data berhasil diubah');
                return redirect()->route('user.index');
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('Gagal',$e->getMessage());
                return redirect()->route('user.index');
            }
        }else{
            Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah User!');
            return redirect()->route('dashboard.index');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('Delete User')){

            $user_id = Crypt::decrypt($id);
            $user = User::find($user_id);
    
            $data = [
                'is_active' => 0,
                'updated_by' => 'Sistem'
            ];
            
            $response = $user->update($data);
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
        else{
            Alert::warning('Gagal', 'Anda tidak memiliki akses menghapus User!');
            return redirect()->route('dashboard.index');
        }
    }

    public function profile($id)
    {
        try {
            $user_id = Crypt::decrypt($id);
            $user = User::find($user_id);
            if ($user->u_id == auth()->user()->u_id) {
                return view('dashboard.profile.index',compact('user'));
            } 
            else {
                Alert::warning('Gagal', 'Anda tidak memiliki akses mengubah password akun ini!');
                return redirect()->route('dashboard');
            }
            
        }
        catch(\Exception $e){
            Alert::warning('Gagal',$e->getMessage());
            return redirect()->route('dashboard');
        }
    }

    public function profileupdate(Request $request,$id)
    {
        $rules = [
            'newpassword' => 'min:6',
        ];

        $rules_message = [
            'min' => 'Kolom :attribute minimal 6 karakter',
        ];

        $attribute = [
            'newpassword' => 'Password baru',
        ];

        $this->validate($request,$rules,$rules_message,$attribute);
        try{
            $user_id = Crypt::decrypt($id);
            $user = User::find($user_id);
            if($request->oldpassword){
                if(Hash::check($request->oldpassword,$user->u_password)){
                    if($request->newpassword){
                        $data['u_password'] = Hash::make($request->newpassword);
                    }
                    else{
                        return redirect()->route('user.profile',$id)->withErrors('Password baru harus diisi');
                    }
                }
                else{
                    return redirect()->route('user.profile',$id)->withErrors('Password lama salah');
                }
                $user->update($data);
                Alert::success('Sukses','Password berhasil diubah');
            }
            return redirect()->route('user.profile',$id);
        }
        catch(\Exception $e){
            Alert::warning('Gagal',$e->getMessage());
            return redirect()->route('dashboard');
        }
    }
    
    /**
     * Mengambil data user by id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function getdatauser(Request $request,$id){
        if($request->ajax()){
            $user_id = Crypt::decrypt($id);
            $datauser = User::find($user_id);
            $response = [
                'success' => true,
                'message' => 'Sukses',
                'data' => $datauser,
            ];
        }else{
            $response = [
                'success' => false,
                'message' => 'Gagal',
                'data' => 'Data tidak ditemukan',
            ];    
        }
        
        return $response;
    }
}
