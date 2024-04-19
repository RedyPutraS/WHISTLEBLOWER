<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivilegeGroup extends Model
{
    protected $table = 'privilegegroup';
    protected $primaryKey = 'pg_id';
    protected $guarded = [];

    public function privilege()
    {
        return $this->hasMany(Privilege::class, 'pg_id', 'pg_id')->orderBy('p_nama')->where(__FUNCTION__ . '.is_active', 1);
    }

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }
}
