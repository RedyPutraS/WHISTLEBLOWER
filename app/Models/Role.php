<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'r_id';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function role_privilege()
    {
        return $this->hasMany(RolePrivilege::class, 'r_id', 'r_id')->where(__FUNCTION__ . '.is_active', 1);
    }
}
