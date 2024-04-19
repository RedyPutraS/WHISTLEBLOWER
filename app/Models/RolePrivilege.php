<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    protected $table = 'role_privilege';
    protected $primaryKey = 'rp_id';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }
}
