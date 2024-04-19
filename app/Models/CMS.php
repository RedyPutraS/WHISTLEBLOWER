<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    protected $table = 'cms';
    protected $primaryKey = 'cms_id';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function scopeByPage($query)
    {
        return $query->groupBy('cms_urutan')->select('cms_urutan')->orderBy('cms_urutan');
    }

    public function scopeFindContent($query, $id)
    {
        return $query->where('cms_id', $id)->first();
    }
}
