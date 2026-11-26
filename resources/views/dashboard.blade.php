@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

    <div class="mb-4">
        <h4 class="mb-1">Selamat datang, {{ auth()->user()->name }}</h4>
        <span class="text-muted">Anda masuk sebagai</span>
        <span class="badge text-bg-primary">{{ auth()->user()->nama_role }}</span>
    </div>

    @include('dashboard._kartu', ['kartu' => $kartuAset, 'kolom' => 'col-12 col-sm-6 col-xl'])
    @include('dashboard._kartu', ['kartu' => $kartuOperasional, 'kolom' => 'col-12 col-sm-6 col-xl-3'])

    <div class="row g-3 mb-3">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-bar-chart me-2"></i>Jumlah Aset per Kategori
                </div>
                <div class="card-body">
                    @if ($totalSarana > 0)
                        <div style="height: 320px;"><canvas id="chartKategori"></canvas></div>
                    @else
                        <p class="text-muted text-center py-5 mb-0">Belum ada data sarana.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-pie-chart me-2"></i>Komposisi Kondisi Aset
                </div>
                <div class="card-body">
                    @if ($totalSarana > 0)
                        <div style="height: 320px;"><canvas id="chartKondisi"></canvas></div>
                    @else
                        <p class="text-muted text-center py-5 mb-0">Belum ada data sarana.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-graph-up me-2"></i>Tren Peminjaman dan Laporan Kerusakan (6 Bulan Terakhir)
                </div>
                <div class="card-body">
                    <div style="height: 300px;"><canvas id="chartTren"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-hourglass-split me-2"></i>{{ $judulUsulan }}
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($usulanMenunggu as $u)
                        <li class="list-group-item">
                            <div class="fw-semibold">{{ $u->nama_barang }}</div>
                            <div class="text-muted">
                                {{ $u->pengusul->name }} &middot; {{ $u->created_at->diffForHumans() }}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada usulan.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-alarm me-2"></i>Peminjaman Jatuh Tempo
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($jatuhTempo as $p)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $p->sarana?->nama_barang ?? $p->prasarana?->nama_ruang ?? '-' }}</div>
                                    <div class="text-muted">
                                        {{ $p->peminjam }} &middot; {{ $p->tanggal_rencana_kembali->translatedFormat('d M Y') }}
                                    </div>
                                </div>
                                @if ($p->tanggal_rencana_kembali->isPast())
                                    <span class="badge text-bg-danger">Terlambat</span>
                                @else
                                    <span class="badge text-bg-warning">Segera</span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada peminjaman yang jatuh tempo.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-tools me-2"></i>Perbaikan Sedang Berjalan
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($perbaikan as $r)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $r->sarana?->nama_barang ?? $r->prasarana?->nama_ruang ?? '-' }}</div>
                                    <div class="text-muted">{{ \Illuminate\Support\Str::limit($r->deskripsi, 40) }}</div>
                                </div>
                                <span class="badge {{ $r->status === 'diproses' ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                    {{ \App\Models\LaporanKerusakan::STATUS[$r->status] ?? $r->status }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada perbaikan berjalan.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        Chart.defaults.font.size = 14;

        const elKategori = document.getElementById('chartKategori');
        if (elKategori) {
            new Chart(elKategori, {
                type: 'bar',
                data: {
                    labels: @json($labelKategori),
                    datasets: [{
                        label: 'Jumlah unit',
                        data: @json($dataKategori),
                        backgroundColor: '#0d6efd',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });
        }

        const elKondisi = document.getElementById('chartKondisi');
        if (elKondisi) {
            new Chart(elKondisi, {
                type: 'doughnut',
                data: {
                    labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                    datasets: [{
                        data: [{{ $baik }}, {{ $rusakRingan }}, {{ $rusakBerat }}],
                        backgroundColor: ['#198754', '#ffc107', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelTren),
                datasets: [
                    {
                        label: 'Peminjaman',
                        data: @json($trenPeminjaman),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, .15)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Laporan Kerusakan',
                        data: @json($trenKerusakan),
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, .15)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    </script>
@endpush