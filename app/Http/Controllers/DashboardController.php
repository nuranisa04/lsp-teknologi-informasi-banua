<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\PicPerusahaan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPerusahaan =
            Perusahaan::count();

        $totalCalon =
            Perusahaan::where(
                'status',
                'Calon'
            )->count();

        $totalTerverifikasi =
            Perusahaan::where(
                'status_kontak',
                'Terverifikasi PIC'
            )->count();

        $totalPic =
            PicPerusahaan::count();

        $perusahaanTerbaru =
            Perusahaan::latest()
                ->take(5)
                ->get();

        return view(
            'dashboard',
            compact(
                'totalPerusahaan',
                'totalCalon',
                'totalTerverifikasi',
                'totalPic',
                'perusahaanTerbaru'
            )
        );
    }
}