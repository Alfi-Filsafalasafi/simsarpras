@php
    $user = auth()->user();

    $menu = collect(config('menu'))
        ->map(function ($section) use ($user) {
            $section['items'] = collect($section['items'])
                ->filter(fn ($item) => in_array('*', $item['roles']) || in_array($user->role, $item['roles']))
                ->values();

            return $section;
        })
        ->filter(fn ($section) => $section['items']->isNotEmpty());
@endphp

<div class="offcanvas-lg offcanvas-start sidebar-wrap" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="sidebar sidebar-inner bg-primary text-white d-flex flex-column">

        <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-white border-opacity-25">
            <a href="{{ route('dashboard') }}" id="sidebarLabel" class="d-flex align-items-center text-white text-decoration-none">
                <i class="bi bi-buildings-fill fs-3 me-2"></i>
                <span class="fs-4 fw-bold">SIMSARPRAS</span>
            </a>
            <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Tutup"></button>
        </div>

        <nav class="flex-grow-1 px-3 py-3">
            @foreach ($menu as $section)
                <div class="sidebar-heading text-uppercase fw-semibold px-2 mb-2 {{ $loop->first ? '' : 'mt-4' }}">
                    {{ $section['section'] }}
                </div>

                <ul class="nav flex-column gap-1">
                    @foreach ($section['items'] as $item)
                        @php
                            $url = Route::has($item['route']) ? route($item['route']) : '#';
                            $active = request()->routeIs($item['active']);
                        @endphp
                        <li class="nav-item">
                            <a href="{{ $url }}" class="nav-link d-flex align-items-center {{ $active ? 'active' : '' }}">
                                <i class="bi {{ $item['icon'] }} me-3"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </nav>

        <div class="px-3 py-3 border-top border-white border-opacity-25">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle fs-2 me-2"></i>
                <div class="text-truncate">
                    <div class="fw-semibold text-truncate">{{ $user->name }}</div>
                    <div class="text-white-50">{{ $user->nama_role }}</div>
                </div>
            </div>
        </div>

    </div>
</div>