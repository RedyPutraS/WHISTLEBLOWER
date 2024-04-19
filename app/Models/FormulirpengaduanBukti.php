<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class FormulirpengaduanBukti extends Model
{
    use EncryptedAttribute;

    protected $table = 'formulirpengaduan_bukti';
    protected $primaryKey = 'fb_id';
    protected $guarded = [];
    protected $appends = ['attachment'];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'fb_keterangan', 'created_by', 'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function formulirpengaduan()
    {
        return $this->belongsTo(Formulirpengaduan::class, 'f_id', 'f_id');
    }

    public function getAttachmentAttribute()
    {
        if ($this->formulirpengaduan->f_sumber == 'Email') {
            return asset('storage/email/' . $this->fb_file_bukti);
        } 
        else {
            return asset('storage/report/' . $this->fb_file_bukti);
        }
        
    }
}
