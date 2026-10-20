<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicMitra extends Model
{
    protected $table = 'pic_mitra';

    protected $primaryKey = 'id_pic';

    protected $fillable = [
        'id_mitra',
        'nama_pic',
        'jabatan',
        'email',
        'no_whatsapp',
        'status',
    ];

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(
            Mitra::class,
            'id_mitra',
            'id_mitra'
        );
    }
}
