<?php

namespace App\Http\Controllers;

use App\Models\Mitra;

class DashboardController extends Controller
{
    public function index()
    {
        $statusCounts = Mitra::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalMitra = (int) $statusCounts->sum();
        $totalAktif = (int) $statusCounts->get('Aktif', 0);
        $totalCalon = (int) $statusCounts->get('Calon', 0);
        $totalTidakAktif = (int) $statusCounts->get('Tidak Aktif', 0);

        $mitraPerBidang = Mitra::query()
            ->select('bidang_usaha')
            ->selectRaw('COUNT(*) as total')
            ->whereNotNull('bidang_usaha')
            ->where('bidang_usaha', '<>', '')
            ->groupBy('bidang_usaha')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($bidang) use ($totalMitra) {
                $bidang->percentage = $totalMitra > 0
                    ? (int) round(($bidang->total / $totalMitra) * 100)
                    : 0;

                return $bidang;
            });

        $mitraTerbaru =
            Mitra::latest()
                ->take(10)
                ->get();

        return view('dashboard', compact(
            'totalMitra',
            'totalAktif',
            'totalCalon',
            'totalTidakAktif',
            'mitraPerBidang',
            'mitraTerbaru',
        ));
    }
}
