@extends('layouts.app')

@section('title', 'Data Prasarana')
@section('page_title', 'Data Prasarana')

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="mb-0">Daftar Prasarana</h4>
            <span class="text-muted">Gedung dan ruang yang dimiliki sekolah</span>
        </div>
        <a href="{{ route('prasarana.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Prasarana
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('prasarana.index') }}" class="row g-2">
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" value="{{ request('q') }}"
                               placeholder="Cari kode, nama ruang, atau penanggung jawab">
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <select name="jenis" class="form-select">
                        <option value="">Semua jenis</option>
                        @foreach ($jenisList as $j)
                            <option value="{{ $j }}" @selected(request('jenis') === $j)>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-lg-2">
                    <select name="kondisi" class="form-select">
                        <option value="">Semua kondisi</option>
                        @foreach ($kondisiList as $kode => $label)
                            <option value="{{ $kode }}" @selected(request('kondisi') === $kode)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-funnel me-1"></i> Cari
                    </button>
                    <a href="{{ route('prasarana.index') }}" class="btn btn-outline-secondary flex-grow-1">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Nama Ruang</th>
                        <th>Jenis</th>
                        <th>Luas</th>
                        <th>Kapasitas</th>
                        <th>Kondisi</th>
                        <th>Penanggung Jawab</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prasarana as $p)
                        <tr>
                            <td>{{ $prasarana->firstItem() + $loop->index }}</td>
                            <td>
                                @if ($p->foto_url)
                                    <img src="{{ $p->foto_url }}" alt="Foto {{ $p->nama_ruang }}" class="rounded"
                                         style="width: 56px; height: 56px; object-fit: cover;">
                                @else
                                    <div class="rounded bg-light text-muted d-flex align-items-center justify-content-center"
                                         style="width: 56px; height: 56px;">
                                        <i class="bi bi-image fs-4"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $p->kode_ruang }}</td>
                            <td>{{ $p->nama_ruang }}</td>
                            <td>{{ $p->jenis }}</td>
                            <td>{{ $p->luas_format }}</td>
                            <td>{{ $p->kapasitas ?? '-' }}</td>
                            <td><span class="badge text-bg-{{ $p->kondisi_warna }}">{{ $p->kondisi_label }}</span></td>
                            <td>{{ $p->penanggung_jawab ?? '-' }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('prasarana.show', $p) }}" class="btn btn-outline-primary" title="Lihat detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('prasarana.edit', $p) }}" class="btn btn-outline-warning" title="Ubah">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" title="Hapus"
                                        data-bs-toggle="modal" data-bs-target="#modalHapus"
                                        data-action="{{ route('prasarana.destroy', $p) }}"
                                        data-nama="{{ $p->kode_ruang }} - {{ $p->nama_ruang }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Data prasarana belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($prasarana->total() > 0)
            <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span class="text-muted">
                    Menampilkan {{ $prasarana->firstItem() }} sampai {{ $prasarana->lastItem() }}
                    dari {{ $prasarana->total() }} data
                </span>
                {{ $prasarana->links() }}
            </div>
        @endif
    </div>

    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="formHapus">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Hapus Prasarana</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Yakin ingin menghapus <strong id="namaHapus"></strong>?
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('modalHapus').addEventListener('show.bs.modal', function (event) {
            const tombol = event.relatedTarget;
            document.getElementById('formHapus').action = tombol.dataset.action;
            document.getElementById('namaHapus').textContent = tombol.dataset.nama;
        });
    </script>
@endpush