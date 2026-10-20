@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb', 'Dashboard')

@push('styles')
    <style>
        .dashboard-page {
            display: grid;
            gap: 22px;
        }

        .dashboard-welcome {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            min-height: 170px;
            padding: 30px 34px;
            overflow: hidden;
            border: 1px solid #292929;
            border-left: 4px solid var(--yellow);
            border-radius: 18px;
            background:
                radial-gradient(ellipse at 85% 110%, rgba(244, 205, 0, .15), transparent 35%),
                linear-gradient(115deg, #1d1d1d 0%, #292929 68%, #333128 100%);
            box-shadow: 0 15px 34px rgba(28, 27, 23, .13);
            color: #fff;
        }

        .dashboard-welcome::after {
            position: absolute;
            top: -130px;
            right: 210px;
            width: 320px;
            height: 320px;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 50%;
            content: "";
            pointer-events: none;
        }

        .dashboard-welcome::before {
            position: absolute;
            right: -44px;
            bottom: -138px;
            width: 270px;
            height: 270px;
            border: 1px solid rgba(244, 205, 0, .15);
            border-radius: 50%;
            box-shadow: 0 0 0 22px rgba(244, 205, 0, .025), 0 0 0 44px rgba(244, 205, 0, .02);
            content: "";
            pointer-events: none;
        }

        .dashboard-welcome-copy {
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        .dashboard-welcome-title {
            margin: 0;
            color: #fff;
            font-size: clamp(25px, 3vw, 35px);
            font-weight: 800;
            letter-spacing: -.04em;
            line-height: 1.15;
        }

        .dashboard-welcome-description {
            max-width: 560px;
            margin: 10px 0 0;
            color: rgba(255, 255, 255, .7);
            font-size: 13px;
            line-height: 1.65;
        }

        .dashboard-welcome-meta {
            position: relative;
            z-index: 1;
            display: flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 10px;
            max-width: 100%;
            padding: 11px 15px;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 12px;
            background: rgba(255, 255, 255, .09);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .08);
            backdrop-filter: blur(12px);
        }

        .dashboard-date-icon {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border-radius: 9px;
            background: var(--yellow);
            color: #292929;
            font-size: 15px;
        }

        .dashboard-date-text {
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: -.02em;
            line-height: 1.4;
        }

        .dashboard-section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 12px;
        }

        .dashboard-section-eyebrow {
            display: block;
            margin-bottom: 4px;
            color: #927b17;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .dashboard-section-title {
            margin: 0;
            color: #292929;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.025em;
        }

        .dashboard-section-note {
            margin: 0;
            color: #858178;
            font-size: 11px;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 13px;
        }

        .dashboard-stat {
            display: grid;
            gap: 12px;
            min-width: 0;
            min-height: 150px;
            padding: 16px 17px;
            border: 1px solid #ece8dc;
            border-top: 3px solid var(--stat-accent);
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 6px 18px rgba(38, 34, 20, .04);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .dashboard-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(38, 34, 20, .08);
        }

        .dashboard-stat--total {
            --stat-accent: #c3a116;
            --stat-tint: #fff8df;
        }

        .dashboard-stat--active {
            --stat-accent: #348467;
            --stat-tint: #eaf6f0;
        }

        .dashboard-stat--candidate {
            --stat-accent: #bf8b1e;
            --stat-tint: #fff5df;
        }

        .dashboard-stat--inactive {
            --stat-accent: #7b8189;
            --stat-tint: #f0f1f3;
        }

        .dashboard-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .dashboard-stat-icon {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: grid;
            place-items: center;
            border: 1px solid color-mix(in srgb, var(--stat-accent) 18%, white);
            border-radius: 11px;
            background: var(--stat-tint);
            color: var(--stat-accent);
            font-size: 16px;
        }

        .dashboard-stat-label {
            color: #615f59;
            font-size: 11px;
            font-weight: 700;
        }

        .dashboard-stat-value {
            display: block;
            margin-top: auto;
            color: #262626;
            font-size: 29px;
            font-weight: 850;
            letter-spacing: -.055em;
            line-height: 1;
        }

        .dashboard-stat-note {
            margin: -5px 0 0;
            color: #89867e;
            font-size: 10px;
            line-height: 1.4;
        }

        .dashboard-insights {
            overflow: hidden;
            border: 1px solid #ece8dc;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(38, 34, 20, .04);
        }

        .dashboard-insights-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 17px 20px 14px;
            border-bottom: 1px solid #f0eee7;
        }

        .dashboard-insights-icon {
            display: grid;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            place-items: center;
            border: 1px solid #f0e5ae;
            border-radius: 11px;
            background: #fff9df;
            color: #756317;
            font-size: 16px;
        }

        .dashboard-insights-title {
            margin: 0;
            color: #292929;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -.015em;
        }

        .dashboard-insights-description {
            margin: 3px 0 0;
            color: #858178;
            font-size: 10px;
        }

        .dashboard-business-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            padding: 15px 20px 18px;
        }

        .dashboard-business-item {
            min-width: 0;
        }

        .dashboard-business-item-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .dashboard-business-name {
            min-width: 0;
            color: #393832;
            font-size: 11px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .dashboard-business-total {
            flex: 0 1 auto;
            color: #6d5c12;
            font-size: 10px;
            font-weight: 800;
            text-align: right;
        }

        .dashboard-business-track {
            height: 5px;
            margin-top: 10px;
            overflow: hidden;
            border-radius: 99px;
            background: #eeece5;
        }

        .dashboard-business-progress {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #d5b52e, #f4cd00);
        }

        .dashboard-business-empty {
            grid-column: 1 / -1;
            padding: 14px;
            color: #858178;
            font-size: 11px;
            text-align: center;
        }

        .dashboard-panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 17px 20px 14px;
            border-bottom: 1px solid #f0eee7;
        }

        .dashboard-panel-heading-copy {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .dashboard-panel-heading-icon {
            display: grid;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            place-items: center;
            border: 1px solid #f0e5ae;
            border-radius: 11px;
            background: #fff9df;
            color: #756317;
            font-size: 16px;
        }

        .dashboard-panel-title {
            margin: 0;
            color: #262626;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .dashboard-panel-description {
            margin: 4px 0 0;
            color: #858178;
            font-size: 11px;
        }

        .dashboard-panel {
            min-width: 0;
            overflow: hidden;
            border: 1px solid #ece8dc;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(38, 34, 20, .04);
        }

        .dashboard-panel-button {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 7px;
            padding: 9px 13px;
            border: 1px solid #e6d36c;
            border-radius: 9px;
            background: #fff9df;
            color: #4b4110;
            font-size: 12px;
            font-weight: 700;
            transition: background-color .18s ease, border-color .18s ease, transform .18s ease;
        }

        .dashboard-panel-button:hover {
            transform: translateY(-1px);
            border-color: #d5bd43;
            background: #fff2b8;
            color: #302908;
        }

        .dashboard-mitra-table-wrap {
            padding: 12px 20px 8px;
        }

        .dashboard-mitra-table {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: #fffdf5;
            margin-bottom: 0;
        }

        .dashboard-mitra-name {
            color: #262626;
            font-size: 13px;
            font-weight: 700;
        }

        .dashboard-mitra-email {
            display: block;
            margin-top: 3px;
            color: #858585;
            font-size: 11px;
            overflow-wrap: anywhere;
        }

        .dashboard-status {
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .dashboard-mitra-table thead th {
            padding: 12px 14px;
            border-bottom: 1px solid #f0e6b8;
            background: #fff9df;
            color: #625414;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            text-align: center;
            white-space: nowrap;
        }

        .dashboard-mitra-table tbody td {
            padding: 15px 14px;
            border-color: #f0eee7;
            color: #5f5f5f;
            font-size: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .dashboard-empty {
            padding: 42px 20px !important;
            color: #858585;
            text-align: center;
        }

        .dashboard-empty i {
            display: block;
            margin-bottom: 9px;
            color: #a58b16;
            font-size: 26px;
        }

        @media (max-width: 991px) {
            .dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dashboard-welcome {
                align-items: center;
                padding: 22px;
            }

            .dashboard-welcome-meta {
                width: auto;
            }

            .dashboard-mitra-table-wrap {
                padding: 10px 14px 4px;
            }
        }

        @media (max-width: 767px) {
            .dashboard-welcome {
                align-items: flex-start;
                flex-direction: column;
                padding: 22px;
            }

            .dashboard-welcome-meta {
                align-self: flex-start;
            }

            .dashboard-panel-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .dashboard-panel-button {
                justify-content: center;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .dashboard-stat {
                min-height: 138px;
                padding: 15px 16px;
            }

            .dashboard-welcome {
                min-height: 0;
                padding: 22px;
            }

            .dashboard-section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }

            .dashboard-insights-heading {
                padding: 14px;
            }

        }
    </style>
@endpush

@section('content')
    <div class="dashboard-page">
        <section class="dashboard-welcome" aria-labelledby="dashboard-welcome-title">
            <div class="dashboard-welcome-copy">
                <h1 class="dashboard-welcome-title" id="dashboard-welcome-title">
                    Selamat datang, {{ auth()->user()->nama }}!
                </h1>
                <p class="dashboard-welcome-description">
                    Pantau data dan status mitra LSP secara menyeluruh.
                </p>
            </div>

            <aside class="dashboard-welcome-meta" aria-label="Tanggal">
                <i class="bi bi-calendar3 dashboard-date-icon" aria-hidden="true"></i>
                <time
                    class="dashboard-date-text"
                    datetime="{{ now()->toDateString() }}"
                >{{ now()->locale('id')->translatedFormat('l, d F Y') }}</time>
            </aside>
        </section>

        <section aria-labelledby="dashboard-summary-title">
            <div class="dashboard-section-heading">
                <div>
                    <h2 class="dashboard-section-title" id="dashboard-summary-title">Statistik Mitra</h2>
                </div>
                <p class="dashboard-section-note">Data mitra berdasarkan status saat ini</p>
            </div>

            <div class="dashboard-stats" aria-label="Ringkasan status mitra">
                <article class="dashboard-stat dashboard-stat--total">
                    <div class="dashboard-stat-top">
                        <span class="dashboard-stat-label">Total mitra</span>
                        <span class="dashboard-stat-icon" aria-hidden="true">
                            <i class="bi bi-buildings"></i>
                        </span>
                    </div>
                    <strong class="dashboard-stat-value">{{ number_format($totalMitra, 0, ',', '.') }}</strong>
                    <p class="dashboard-stat-note">Seluruh data mitra terdaftar</p>
                </article>

                <article class="dashboard-stat dashboard-stat--active">
                    <div class="dashboard-stat-top">
                        <span class="dashboard-stat-label">Mitra aktif</span>
                        <span class="dashboard-stat-icon" aria-hidden="true">
                            <i class="bi bi-check-circle"></i>
                        </span>
                    </div>
                    <strong class="dashboard-stat-value">{{ number_format($totalAktif, 0, ',', '.') }}</strong>
                    <p class="dashboard-stat-note">Mitra dengan status aktif</p>
                </article>

                <article class="dashboard-stat dashboard-stat--candidate">
                    <div class="dashboard-stat-top">
                        <span class="dashboard-stat-label">Calon mitra</span>
                        <span class="dashboard-stat-icon" aria-hidden="true">
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                    </div>
                    <strong class="dashboard-stat-value">{{ number_format($totalCalon, 0, ',', '.') }}</strong>
                    <p class="dashboard-stat-note">Mitra dalam status calon</p>
                </article>

                <article class="dashboard-stat dashboard-stat--inactive">
                    <div class="dashboard-stat-top">
                        <span class="dashboard-stat-label">Tidak aktif</span>
                        <span class="dashboard-stat-icon" aria-hidden="true">
                            <i class="bi bi-pause-circle"></i>
                        </span>
                    </div>
                    <strong class="dashboard-stat-value">{{ number_format($totalTidakAktif, 0, ',', '.') }}</strong>
                    <p class="dashboard-stat-note">Mitra dengan status tidak aktif</p>
                </article>
            </div>
        </section>

        <section class="dashboard-insights" aria-labelledby="dashboard-business-title">
            <div class="dashboard-insights-heading">
                <span class="dashboard-insights-icon" aria-hidden="true">
                    <i class="bi bi-bar-chart-line"></i>
                </span>
                <div>
                    <h2 class="dashboard-insights-title" id="dashboard-business-title">Kategori Mitra</h2>
                </div>
            </div>
            <div class="dashboard-business-grid">
                @forelse ($mitraPerBidang as $bidang)
                    <article class="dashboard-business-item">
                        <div class="dashboard-business-item-top">
                            <span class="dashboard-business-name">{{ $bidang->bidang_usaha }}</span>
                            <span class="dashboard-business-total">
                                {{ number_format($bidang->total, 0, ',', '.') }} mitra
                                <span aria-hidden="true">·</span> {{ $bidang->percentage }}%
                            </span>
                        </div>
                        <div
                            class="dashboard-business-track"
                            role="progressbar"
                            aria-label="Persentase mitra bidang {{ $bidang->bidang_usaha }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-valuenow="{{ $bidang->percentage }}"
                        >
                            <span
                                class="dashboard-business-progress"
                                style="width: {{ $bidang->percentage }}%"
                            ></span>
                        </div>
                    </article>
                @empty
                    <p class="dashboard-business-empty">Belum ada kategori mitra untuk ditampilkan.</p>
                @endforelse
            </div>
        </section>

        <section class="dashboard-panel" aria-labelledby="latest-mitras-title">
            <div class="dashboard-panel-heading">
                <div class="dashboard-panel-heading-copy">
                    <span class="dashboard-panel-heading-icon" aria-hidden="true">
                        <i class="bi bi-buildings"></i>
                    </span>
                    <div>
                        <h2 class="dashboard-panel-title" id="latest-mitras-title">Mitra Terdaftar</h2>
                    </div>
                </div>
                @if ($mitraTerbaru->count() > 5)
                    <button
                        class="dashboard-panel-button"
                        id="dashboard-mitra-toggle"
                        type="button"
                        aria-expanded="false"
                        aria-controls="dashboard-mitra-list"
                    >
                        Tampilkan lebih banyak
                        <i class="bi bi-chevron-down" aria-hidden="true"></i>
                    </button>
                @endif
            </div>
            <div class="dashboard-mitra-table-wrap">
                <div class="table-responsive">
                    <table class="table table-hover align-middle dashboard-mitra-table" aria-labelledby="latest-mitras-title">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Mitra</th>
                                <th scope="col">Kategori Mitra</th>
                                <th scope="col">Nomor kontak</th>
                                <th scope="col">Status kontak</th>
                            </tr>
                        </thead>
                        <tbody id="dashboard-mitra-list">
                            @forelse ($mitraTerbaru as $item)
                                <tr class="dashboard-mitra-row" @if ($loop->index >= 5) hidden @endif>
                                    <td class="text-center">
                                        <div class="dashboard-mitra-name">
                                            {{ $item->nama_mitra }}
                                        </div>
                                        <div class="dashboard-mitra-email">
                                            {{ $item->email ?: 'Tidak ada email' }}
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->bidang_usaha ?: '-' }}</td>
                                    <td class="text-center">{{ $item->no_telepon ?: '-' }}</td>
                                    <td>
                                        @if ($item->status_kontak === 'Terverifikasi PIC')
                                            <span class="badge bg-success dashboard-status">Terverifikasi PIC</span>
                                        @elseif ($item->status_kontak === 'Kontak Mitra')
                                            <span class="badge bg-info text-dark dashboard-status">Kontak Mitra</span>
                                        @elseif ($item->status_kontak === 'Bukan PIC')
                                            <span class="badge bg-danger dashboard-status">Bukan PIC</span>
                                        @elseif ($item->status_kontak === 'Tidak Dapat Dihubungi')
                                            <span class="badge bg-secondary dashboard-status">Tidak Dapat Dihubungi</span>
                                        @else
                                            <span class="badge bg-warning text-dark dashboard-status">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="dashboard-empty">
                                        <i class="bi bi-building" aria-hidden="true"></i>
                                        Belum ada data mitra.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const mitraRows = document.querySelectorAll('.dashboard-mitra-row');
        const mitraToggle = document.getElementById('dashboard-mitra-toggle');
        const visibleMitraCount = document.getElementById('dashboard-mitra-visible-count');

        if (mitraToggle) {
            mitraToggle.addEventListener('click', () => {
                const isExpanded = mitraToggle.getAttribute('aria-expanded') === 'true';
                const visibleLimit = isExpanded ? 5 : 10;

                mitraRows.forEach((row, index) => {
                    row.hidden = index >= visibleLimit;
                });

                mitraToggle.setAttribute('aria-expanded', String(!isExpanded));
                mitraToggle.innerHTML = isExpanded
                    ? 'Tampilkan lebih banyak <i class="bi bi-chevron-down" aria-hidden="true"></i>'
                    : 'Tampilkan lebih sedikit <i class="bi bi-chevron-up" aria-hidden="true"></i>';
                visibleMitraCount.textContent = String(Math.min(mitraRows.length, visibleLimit));
            });
        }
    </script>
@endpush
