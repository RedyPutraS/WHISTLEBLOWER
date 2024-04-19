<?php

namespace App;

use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * replace primary key
     *
     * @var string
     */
    protected $primaryKey = 'u_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_username','u_nama', 'u_email', 'u_password','u_password_raw','r_id','is_active'
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'u_password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table.'.is_active', 1);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'r_id', 'r_id');
    }

    public function users_role()
    {
        return $this->hasMany(UsersRole::class, 'r_id', 'r_id')->where(__FUNCTION__ . '.r_is_active', 1);
    }

    public function can($permission = null, $id = null)
    {
        // Allowed permission requested in auth()->user()->can(), example: Manage User
        $permission = explode(' ', $permission, 2);
        $allowedprivilege = $permission[0]; // example: Manage
        $allowedprivilegegroup = $permission[1]; // example: User
        
        // Reject if request format is invalid. example: User (without Manage or other privilege)
        if (is_null($allowedprivilege)) return false;
        
        // Check my own privileges
        $myprivilegegroups = array_unique($this->role->role_privilege->pluck('privilege.privilegegroup.pg_nama')->toArray());
        $myprivileges = Privilege::whereIn('p_id', $this->role->role_privilege->pluck('p_id'))->whereHas('privilegegroup', function ($query) use ($allowedprivilegegroup) {
            $query->where('pg_nama', $allowedprivilegegroup);
        })->pluck('p_nama')->toArray();

        if ($id == null) {
            if (in_array("Manage", $myprivileges)) {
                $result = true;
            } 
            else {
                $result = in_array($allowedprivilege, $myprivileges);
            }
        } 
        else {
            $result = false;
        }
        return $result;
    }

    public function getAuthPassword()
    {
        return $this->u_password;
    }

}
