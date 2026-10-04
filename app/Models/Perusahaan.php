<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    protected $table = 'data_perusahaan';

    protected $primaryKey = 'id_perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'bidang_usaha',
        'alamat',
        'website',
        'email',
        'no_telepon',
        'sumber_data',
        'status_kontak',
        'status',
    ];

    public function pics(): HasMany
    {
        return $this->hasMany(
            PicPerusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }
}