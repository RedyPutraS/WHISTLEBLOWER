<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Diskusi extends Model
{
    use EncryptedAttribute;

    protected $table = 'diskusi';
    protected $primaryKey = 'd_id';
    protected $guarded = [];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'd_nama', 'd_status', 'created_by', 'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function ruangdiskusi(){
        return $this->hasMany(RuangDiskusi::class,'d_id','d_id');
    }

    public function formulirpengaduan()
    {
        return $this->belongsTo(Formulirpengaduan::class, 'd_noreg', 'f_noreg');
    }
}
