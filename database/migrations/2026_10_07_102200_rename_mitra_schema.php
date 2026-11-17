<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pic_perusahaan', function (Blueprint $table) {
            $table->dropForeign('pic_perusahaan_id_perusahaan_foreign');
        });

        Schema::rename('data_perusahaan', 'data_mitra');
        Schema::rename('pic_perusahaan', 'pic_mitra');

        Schema::table('data_mitra', function (Blueprint $table) {
            $table->renameColumn('id_perusahaan', 'id_mitra');
            $table->renameColumn('nama_perusahaan', 'nama_mitra');
        });

        Schema::table('pic_mitra', function (Blueprint $table) {
            $table->renameColumn('id_perusahaan', 'id_mitra');
        });

        $this->changeContactStatusValues([
            'Belum Diverifikasi',
            'Kontak Perusahaan',
            'Kontak Mitra',
            'Terverifikasi PIC',
            'Bukan PIC',
            'Tidak Dapat Dihubungi',
        ]);

        DB::table('data_mitra')
            ->where('status_kontak', 'Kontak Perusahaan')
            ->update(['status_kontak' => 'Kontak Mitra']);

        $this->changeContactStatusValues([
            'Belum Diverifikasi',
            'Kontak Mitra',
            'Terverifikasi PIC',
            'Bukan PIC',
            'Tidak Dapat Dihubungi',
        ]);

        Schema::table('pic_mitra', function (Blueprint $table) {
            $table->foreign('id_mitra', 'pic_mitra_id_mitra_foreign')
                ->references('id_mitra')
                ->on('data_mitra')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pic_mitra', function (Blueprint $table) {
            $table->dropForeign('pic_mitra_id_mitra_foreign');
        });

        $this->changeContactStatusValues([
            'Belum Diverifikasi',
            'Kontak Perusahaan',
            'Kontak Mitra',
            'Terverifikasi PIC',
            'Bukan PIC',
            'Tidak Dapat Dihubungi',
        ]);

        DB::table('data_mitra')
            ->where('status_kontak', 'Kontak Mitra')
            ->update(['status_kontak' => 'Kontak Perusahaan']);

        $this->changeContactStatusValues([
            'Belum Diverifikasi',
            'Kontak Perusahaan',
            'Terverifikasi PIC',
            'Bukan PIC',
            'Tidak Dapat Dihubungi',
        ]);

        Schema::table('data_mitra', function (Blueprint $table) {
            $table->renameColumn('nama_mitra', 'nama_perusahaan');
            $table->renameColumn('id_mitra', 'id_perusahaan');
        });

        Schema::table('pic_mitra', function (Blueprint $table) {
            $table->renameColumn('id_mitra', 'id_perusahaan');
        });

        Schema::rename('pic_mitra', 'pic_perusahaan');
        Schema::rename('data_mitra', 'data_perusahaan');

        Schema::table('pic_perusahaan', function (Blueprint $table) {
            $table->foreign('id_perusahaan', 'pic_perusahaan_id_perusahaan_foreign')
                ->references('id_perusahaan')
                ->on('data_perusahaan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * @param  array<int, string>  $values
     */
    private function changeContactStatusValues(array $values): void
    {
        Schema::table('data_mitra', function (Blueprint $table) use ($values) {
            $table->enum('status_kontak', $values)
                ->nullable()
                ->default('Belum Diverifikasi')
                ->change();
        });
    }
};
