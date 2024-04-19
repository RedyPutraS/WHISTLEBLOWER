<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'pgtr_id';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function scopeByLabel($query)
    {
        return $query->groupBy('pgtr_label')->select('pgtr_label');
    }

    public function scopeFindConfig($query, $id)
    {
        return $query->where('pgtr_id', $id)->first();
    }
}
