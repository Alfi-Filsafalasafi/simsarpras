<div class="row g-3">
    <div class="col-md-4">
        <label for="kode_ruang" class="form-label">Kode Ruang <span class="text-danger">*</span></label>
        <input type="text" name="kode_ruang" id="kode_ruang"
               class="form-control @error('kode_ruang') is-invalid @enderror"
               value="{{ old('kode_ruang', $prasarana->kode_ruang) }}">
        @error('kode_ruang')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="nama_ruang" class="form-label">Nama Ruang <span class="text-danger">*</span></label>
        <input type="text" name="nama_ruang" id="nama_ruang"
               class="form-control @error('nama_ruang') is-invalid @enderror"
               value="{{ old('nama_ruang', $prasarana->nama_ruang) }}" placeholder="Contoh: Ruang Kelas X-1">
        @error('nama_ruang')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
        <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror">
            <option value="">Pilih jenis</option>
            @foreach ($jenisList as $j)
                <option value="{{ $j }}" @selected(old('jenis', $prasarana->jenis) === $j)>{{ $j }}</option>
            @endforeach
        </select>
        @error('jenis')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="luas" class="form-label">Luas</label>
        <div class="input-group">
            <input type="number" step="0.01" min="0" name="luas" id="luas"
                   class="form-control @error('luas') is-invalid @enderror"
                   value="{{ old('luas', $prasarana->luas) }}">
            <span class="input-group-text">m²</span>
            @error('luas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <label for="kapasitas" class="form-label">Kapasitas</label>
        <div class="input-group">
            <input type="number" min="0" name="kapasitas" id="kapasitas"
                   class="form-control @error('kapasitas') is-invalid @enderror"
                   value="{{ old('kapasitas', $prasarana->kapasitas) }}">
            <span class="input-group-text">orang</span>
            @error('kapasitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <label for="tahun_bangun" class="form-label">Tahun Bangun</label>
        <input type="number" name="tahun_bangun" id="tahun_bangun" min="1900" max="{{ date('Y') }}"
               class="form-control @error('tahun_bangun') is-invalid @enderror"
               value="{{ old('tahun_bangun', $prasarana->tahun_bangun) }}" placeholder="{{ date('Y') }}">
        @error('tahun_bangun')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="kondisi" class="form-label">Kondisi <span class="text-danger">*</span></label>
        <select name="kondisi" id="kondisi" class="form-select @error('kondisi') is-invalid @enderror">
            @foreach ($kondisiList as $kode => $label)
                <option value="{{ $kode }}" @selected(old('kondisi', $prasarana->kondisi) === $kode)>{{ $label }}</option>
            @endforeach
        </select>
        @error('kondisi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
        <input type="text" name="penanggung_jawab" id="penanggung_jawab"
               class="form-control @error('penanggung_jawab') is-invalid @enderror"
               value="{{ old('penanggung_jawab', $prasarana->penanggung_jawab) }}">
        @error('penanggung_jawab')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.webp"
               class="form-control @error('foto') is-invalid @enderror">
        @error('foto')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Format jpg, jpeg, png, atau webp. Maksimal 2 MB.</div>

        @if ($prasarana->foto_url)
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="hapus_foto" id="hapus_foto" value="1"
                       @checked(old('hapus_foto'))>
                <label class="form-check-label" for="hapus_foto">Hapus foto saat ini</label>
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label d-block">Pratinjau</label>
        <img id="previewFoto"
             src="{{ $prasarana->foto_url }}"
             alt="Pratinjau foto"
             class="rounded border {{ $prasarana->foto_url ? '' : 'd-none' }}"
             style="max-height: 160px; max-width: 100%; object-fit: cover;">
        <div id="previewKosong" class="text-muted {{ $prasarana->foto_url ? 'd-none' : '' }}">
            <i class="bi bi-image me-1"></i> Belum ada foto
        </div>
    </div>

    <div class="col-12">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea name="keterangan" id="keterangan" rows="3"
                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $prasarana->keterangan) }}</textarea>
        @error('keterangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg me-1"></i> Simpan
    </button>
    <a href="{{ route('prasarana.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>

@push('scripts')
    <script>
        document.getElementById('foto').addEventListener('change', function () {
            const berkas = this.files[0];
            const gambar = document.getElementById('previewFoto');
            const kosong = document.getElementById('previewKosong');

            if (berkas) {
                gambar.src = URL.createObjectURL(berkas);
                gambar.classList.remove('d-none');
                kosong.classList.add('d-none');
            }
        });
    </script>
@endpush