<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicPerusahaan extends Model
{
    protected $table = 'pic_perusahaan';

    protected $primaryKey = 'id_pic';

    protected $fillable = [
        'id_perusahaan',
        'nama_pic',
        'jabatan',
        'email',
        'no_whatsapp',
        'status',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }
}