<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mitra extends Model
{
    public const KATEGORI_MITRA = [
        'Perguruan Tinggi',
        'Sekolah',
        'Lembaga Pelatihan',
        'Perusahaan Teknologi Informasi',
        'Perusahaan Non-Teknologi Informasi',
        'Instansi Pemerintah',
        'BUMN / BUMD',
        'Organisasi / Asosiasi Profesi',
        'Lembaga Sertifikasi',
        'Industri',
        'Lainnya',
    ];

    protected $table = 'data_mitra';

    protected $primaryKey = 'id_mitra';

    protected $fillable = [
        'nama_mitra',
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
            PicMitra::class,
            'id_mitra',
            'id_mitra'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function contactStatusFromPics(?PicMitra $excludingPic = null): string
    {
        if ($this->status_kontak === 'Bukan PIC') {
            return 'Bukan PIC';
        }

        $pics = $this->pics();

        if ($excludingPic) {
            $pics->where('id_pic', '!=', $excludingPic->getKey());
        }

        return $pics->exists()
            ? 'Terverifikasi PIC'
            : 'Belum Diverifikasi';
    }

    public function syncContactStatusFromPics(): void
    {
        $statusKontak = $this->contactStatusFromPics();

        if ($this->status_kontak !== $statusKontak) {
            $this->update(['status_kontak' => $statusKontak]);
        }
    }
}
