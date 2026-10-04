<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\PicPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PicPerusahaanController extends Controller
{
    private function adminOnly(): void
    {
        abort_unless(
            auth()->user()->isAdmin(),
            403
        );
    }

    public function index(Request $request)
    {
        $query = PicPerusahaan::with(
            'perusahaan'
        );

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_pic',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'jabatan',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'no_whatsapp',
                    'like',
                    "%{$search}%"
                )
                ->orWhereHas(
                    'perusahaan',
                    function ($company) use ($search) {
                        $company->where(
                            'nama_perusahaan',
                            'like',
                            "%{$search}%"
                        );
                    }
                );
            });
        }

        $pics = $query
            ->latest('id_pic')
            ->paginate(10)
            ->withQueryString();

        return view(
            'pic.index',
            compact('pics')
        );
    }

    public function create()
    {
        $this->adminOnly();

        $perusahaan = Perusahaan::orderBy(
            'nama_perusahaan'
        )->get();

        return view(
            'pic.tambah_pic',
            compact('perusahaan')
        );
    }

    public function store(Request $request)
    {
        $this->adminOnly();

        $data = $request->validate([
            'id_perusahaan' => [
                'required',
                'exists:data_perusahaan,id_perusahaan',
            ],

            'nama_pic' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'no_whatsapp' => [
                'required',
                'string',
                'max:30',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Aktif',
                    'Tidak Aktif',
                ]),
            ],
        ]);

        PicPerusahaan::create($data);

        Perusahaan::where(
            'id_perusahaan',
            $data['id_perusahaan']
        )->update([
            'status_kontak' =>
                'Terverifikasi PIC',
        ]);

        return redirect()
            ->route('pic.index')
            ->with(
                'success',
                'Data PIC berhasil ditambahkan.'
            );
    }

    public function show(PicPerusahaan $pic)
    {
        $pic->load('perusahaan');

        return view(
            'pic.lihat_pic',
            compact('pic')
        );
    }

    public function edit(PicPerusahaan $pic)
    {
        $this->adminOnly();

        $perusahaan = Perusahaan::orderBy(
            'nama_perusahaan'
        )->get();

        return view(
            'pic.edit_pic',
            compact(
                'pic',
                'perusahaan'
            )
        );
    }

    public function update(
        Request $request,
        PicPerusahaan $pic
    ) {
        $this->adminOnly();

        $data = $request->validate([
            'id_perusahaan' => [
                'required',
                'exists:data_perusahaan,id_perusahaan',
            ],

            'nama_pic' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'no_whatsapp' => [
                'required',
                'string',
                'max:30',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Aktif',
                    'Tidak Aktif',
                ]),
            ],
        ]);

        $pic->update($data);

        return redirect()
            ->route(
                'pic.show',
                $pic
            )
            ->with(
                'success',
                'Data PIC berhasil diperbarui.'
            );
    }

    public function destroy(
        PicPerusahaan $pic
    ) {
        $this->adminOnly();

        $idPerusahaan =
            $pic->id_perusahaan;

        $pic->delete();

        $masihAdaPic =
            PicPerusahaan::where(
                'id_perusahaan',
                $idPerusahaan
            )->exists();

        if (!$masihAdaPic) {
            Perusahaan::where(
                'id_perusahaan',
                $idPerusahaan
            )->update([
                'status_kontak' =>
                    'Belum Diverifikasi',
            ]);
        }

        return redirect()
            ->route('pic.index')
            ->with(
                'success',
                'Data PIC berhasil dihapus.'
            );
    }
}