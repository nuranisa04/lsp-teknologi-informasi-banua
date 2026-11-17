<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Jurusan extends Model
{
    protected $table = 'jurusan_mitra';

    protected $primaryKey = 'id_jurusan';

    protected $fillable = ['id_mitra', 'nama_jurusan', 'no_telepon'];

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'id_mitra', 'id_mitra');
    }

    public function pics(): BelongsToMany
    {
        return $this->belongsToMany(PicMitra::class, 'jurusan_pic', 'id_jurusan', 'id_pic')
            ->withTimestamps();
    }
}
