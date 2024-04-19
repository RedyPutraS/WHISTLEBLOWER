<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'privilege';
    protected $primaryKey = 'p_id';
    protected $guarded = [];

    public function privilegegroup()
    {
        return $this->belongsTo(PrivilegeGroup::class, 'pg_id', 'pg_id');
    }

    public function role_privilege()
    {
        return $this->hasMany(RolePrivilege::class, 'rp_p_id', 'rp_id')->where(__FUNCTION__ . '.is_active', 1);
    }

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }
}
