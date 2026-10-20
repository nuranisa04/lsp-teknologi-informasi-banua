@extends('layouts.app')

@section('title', 'Detail Mitra')

@section('breadcrumb', 'Data Mitra / Detail')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="page-title mb-1">Detail Mitra</h2>
            <p class="text-muted mb-0">Informasi lengkap mitra dan PIC terkait.</p>
        </div>

        <a href="{{ route('mitra.index') }}" class="btn btn-back">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
            Kembali
        </a>
    </div>

    <section class="card mb-4" aria-labelledby="mitra-information-title">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3"
                        style="width: 48px; height: 48px; background: #fff4bf; color: #6c5a00;"
                        aria-hidden="true"
                    >
                        <i class="bi bi-building fs-4"></i>
                    </span>
                    <h3 class="h4 fw-bold mb-1" id="mitra-information-title">
                        {{ $mitra->nama_mitra }}
                    </h3>
                    <p class="text-muted mb-0">{{ $mitra->bidang_usaha }}</p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @if ($mitra->status === 'Aktif')
                        <span class="badge bg-success">Aktif</span>
                    @elseif ($mitra->status === 'Tidak Aktif')
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @else
                        <span class="badge bg-warning text-dark">Calon</span>
                    @endif

                    @if ($mitra->status_kontak === 'Terverifikasi PIC')
                        <span class="badge bg-success">Terverifikasi PIC</span>
                    @elseif ($mitra->status_kontak === 'Kontak Mitra')
                        <span class="badge bg-info text-dark">Kontak Mitra</span>
                    @elseif ($mitra->status_kontak === 'Bukan PIC')
                        <span class="badge bg-danger">Bukan PIC</span>
                    @elseif ($mitra->status_kontak === 'Tidak Dapat Dihubungi')
                        <span class="badge bg-secondary">Tidak Dapat Dihubungi</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                    @endif
                </div>
            </div>

            <hr>

            <div class="row g-4">
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Alamat</span>
                    <span class="fw-medium">{{ $mitra->alamat ?: '-' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Nomor kontak mitra</span>
                    <span class="fw-medium">{{ $mitra->no_telepon ?: '-' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Email mitra</span>
                    <span class="fw-medium">{{ $mitra->email ?: '-' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Website</span>
                    @if ($mitra->website)
                        <a href="{{ $mitra->website }}" target="_blank" rel="noopener noreferrer">
                            {{ $mitra->website }}
                        </a>
                    @else
                        <span class="fw-medium">-</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Sumber data</span>
                    <span class="fw-medium">{{ $mitra->sumber_data ?: '-' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Tanggal ditambahkan</span>
                    <span class="fw-medium">
                        {{ $mitra->created_at?->locale('id')->translatedFormat('d F Y') ?: '-' }}
                    </span>
                </div>
                <div class="col-md-6">
                    <span class="small text-muted d-block mb-1">Diinput oleh</span>
                    <span class="fw-medium">{{ $mitra->user?->nama ?? 'Tidak tercatat' }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="card" aria-labelledby="pic-information-title">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-person-lines-fill text-warning fs-5" aria-hidden="true"></i>
                <h3 class="h5 fw-bold mb-0" id="pic-information-title">Data PIC</h3>
            </div>

            @forelse ($mitra->pics as $pic)
                <div class="rounded-3 border p-3 {{ $loop->last ? '' : 'mb-3' }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <span class="small text-muted d-block mb-1">Nama PIC</span>
                            <span class="fw-semibold">{{ $pic->nama_pic }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="small text-muted d-block mb-1">Jabatan</span>
                            <span class="fw-semibold">{{ $pic->jabatan }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="small text-muted d-block mb-1">Email PIC</span>
                            <span>{{ $pic->email ?: '-' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="small text-muted d-block mb-1">Nomor WhatsApp PIC</span>
                            <span>{{ $pic->no_whatsapp ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3 border bg-light p-3 text-muted">
                    Data PIC belum tersedia untuk mitra ini.
                </div>
            @endforelse
        </div>
    </section>
@endsection
