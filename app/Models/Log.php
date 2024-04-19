<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'l_id';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }
}
