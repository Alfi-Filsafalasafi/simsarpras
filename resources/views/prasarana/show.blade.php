@extends('layouts.app')

@section('title', 'Detail Prasarana')
@section('page_title', 'Detail Prasarana')

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="mb-0">{{ $prasarana->kode_ruang }} - {{ $prasarana->nama_ruang }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('prasarana.edit', $prasarana) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i> Ubah
            </a>
            <a href="{{ route('prasarana.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    @if ($prasarana->foto_url)
                        <img src="{{ $prasarana->foto_url }}" alt="Foto {{ $prasarana->nama_ruang }}"
                             class="img-fluid rounded" style="max-height: 320px; object-fit: cover;">
                    @else
                        <div class="text-muted py-5">
                            <i class="bi bi-image display-1 d-block mb-2"></i>
                            Belum ada foto
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-info-circle me-2"></i>Informasi Prasarana
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Kode Ruang</dt>
                        <dd class="col-sm-8">{{ $prasarana->kode_ruang }}</dd>

                        <dt class="col-sm-4">Nama Ruang</dt>
                        <dd class="col-sm-8">{{ $prasarana->nama_ruang }}</dd>

                        <dt class="col-sm-4">Jenis</dt>
                        <dd class="col-sm-8">{{ $prasarana->jenis }}</dd>

                        <dt class="col-sm-4">Luas</dt>
                        <dd class="col-sm-8">{{ $prasarana->luas_format }}</dd>

                        <dt class="col-sm-4">Kapasitas</dt>
                        <dd class="col-sm-8">{{ $prasarana->kapasitas ? $prasarana->kapasitas.' orang' : '-' }}</dd>

                        <dt class="col-sm-4">Tahun Bangun</dt>
                        <dd class="col-sm-8">{{ $prasarana->tahun_bangun ?? '-' }}</dd>

                        <dt class="col-sm-4">Kondisi</dt>
                        <dd class="col-sm-8">
                            <span class="badge text-bg-{{ $prasarana->kondisi_warna }}">{{ $prasarana->kondisi_label }}</span>
                        </dd>

                        <dt class="col-sm-4">Penanggung Jawab</dt>
                        <dd class="col-sm-8">{{ $prasarana->penanggung_jawab ?? '-' }}</dd>

                        <dt class="col-sm-4">Keterangan</dt>
                        <dd class="col-sm-8">{{ $prasarana->keterangan ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-box-seam me-2"></i>Sarana di Ruang Ini
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prasarana->sarana as $s)
                        <tr>
                            <td class="fw-semibold">{{ $s->kode_barang }}</td>
                            <td>{{ $s->nama_barang }}</td>
                            <td>{{ $s->kategori->nama }}</td>
                            <td>{{ $s->jumlah }}</td>
                            <td>{{ \App\Models\Sarana::KONDISI[$s->kondisi] ?? $s->kondisi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada sarana yang ditempatkan di ruang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection