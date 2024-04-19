<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Pesanemail extends Model
{
    use EncryptedAttribute;

    protected $table = 'pesanemail';
    protected $primaryKey = 'pe_id';
    protected $guarded = [];
    protected $appends = ['attachments'];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'pe_subject', 'pe_fromaddress', 'pe_fromname', 'pe_messagebody', 'created_by', 'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.is_active', 1);
    }

    public function getAttachmentsAttribute()
    {
        if ($this->pe_attachment) {
            return explode(';', $this->pe_attachment);
        } 
        else {
            return [];
        }
    }
}
