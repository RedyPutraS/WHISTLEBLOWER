<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 's_id';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function formulirpengaduan()
    {
        return $this->hasMany(Formulirpengaduan::class, 's_id', 's_id');
    }

    public function formulirpengaduan_riwayat()
    {
        return $this->hasMany(FormulirpengaduanRiwayat::class, 's_id', 's_id');
    }
}
