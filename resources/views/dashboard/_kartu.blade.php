<div class="row g-3 mb-3">
    @foreach ($kartu as $k)
        <div class="{{ $kolom }}">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-{{ $k['warna'] }} bg-opacity-10 text-{{ $k['warna'] }} d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                         style="width: 56px; height: 56px;">
                        <i class="bi {{ $k['icon'] }} fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted">{{ $k['label'] }}</div>
                        <div class="fs-3 fw-bold">{{ number_format($k['nilai'], 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>