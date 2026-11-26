<header class="bg-white border-bottom px-3 px-md-4 py-3 d-flex align-items-center sticky-top">
    <button class="btn btn-primary d-lg-none me-3" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Buka menu">
        <i class="bi bi-list"></i>
    </button>

    <h4 class="mb-0 fw-semibold flex-grow-1">@yield('page_title')</h4>

    <a href="{{ Route::has('notifikasi.index') ? route('notifikasi.index') : '#' }}"
       class="btn btn-light me-2" aria-label="Notifikasi">
        <i class="bi bi-bell fs-5"></i>
    </a>

    <div class="dropdown">
        <button class="btn btn-light d-flex align-items-center dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5 me-2"></i>
            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><span class="dropdown-item-text fw-semibold">{{ auth()->user()->nama_role }}</span></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>