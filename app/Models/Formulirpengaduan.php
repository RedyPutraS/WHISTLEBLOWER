<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Formulirpengaduan extends Model
{
    use EncryptedAttribute;

    protected $table = 'formulirpengaduan';
    protected $primaryKey = 'f_id';
    protected $guarded = [];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'f_token', 'f_nama', 'f_no_telepon', 'f_email', 'f_waktu_kejadian', 'f_tempat_kejadian', 'f_kronologi', 'f_sumber', 'created_by', 'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function formulirpengaduan_bukti()
    {
        return $this->hasMany(FormulirpengaduanBukti::class, 'f_id', 'f_id')->where('is_active', 1);
    }

    public function formulirpengaduan_buktiawal()
    {
        return $this->hasMany(FormulirpengaduanBukti::class, 'f_id', 'f_id')->where('is_active', 1)->where('fb_status', 'Bukti Awal');
    }

    public function formulirpengaduan_buktitambahan()
    {
        return $this->hasMany(FormulirpengaduanBukti::class, 'f_id', 'f_id')->where('is_active', 1)->where('fb_status', 'Bukti Tambahan');
    }

    public function formulirpengaduan_riwayat()
    {
        return $this->hasMany(FormulirpengaduanRiwayat::class, 'f_id', 'f_id')->where('is_active', 1)->orderBy('created_at', 'DESC');
    }

    public function formulirpengaduan_riwayatterbaru()
    {
        return $this->hasOne(FormulirpengaduanRiwayat::class, 'f_id', 'f_id')->latest('created_at');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 's_id', 's_id');
    }

    public function diskusi()
    {
        return $this->hasMany(Diskusi::class, 'd_noreg', 'f_noreg')->where('is_active', 1);
    }
}
