<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class FormulirpengaduanRiwayat extends Model
{
    use EncryptedAttribute;

    protected $table = 'formulirpengaduan_riwayat';
    protected $primaryKey = 'fr_id';
    protected $guarded = [];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'fr_status', 'fr_keterangan', 'created_by', 'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function formulirpengaduan()
    {
        return $this->belongsTo(Formulirpengaduan::class, 'f_id', 'f_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'fr_status', 's_nama');
    }
}
