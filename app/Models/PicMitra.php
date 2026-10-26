<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function jurusans(): BelongsToMany
    {
        return $this->belongsToMany(Jurusan::class, 'jurusan_pic', 'id_pic', 'id_jurusan');
    }
}
