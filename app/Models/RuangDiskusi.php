<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class RuangDiskusi extends Model
{
    use EncryptedAttribute;

    protected $table = 'ruang_diskusi';
    protected $primaryKey = 'rd_id';
    protected $guarded = [];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'rd_pesan', 'rd_tipe_user', 'created_by', 'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function diskusi(){
        return $this->belongsTo(Diskusi::class,'d_id','d_id');
    }
}
