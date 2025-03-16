<!-- components/sidebar.blade.php -->
<aside class="sidebar bg-white shadow-sm">
    <div class="brand-container d-flex justify-content-between align-items-center p-3 border-bottom">
        <div class="brand d-flex align-items-center">
            <div class="brand-icon me-2">
                <i class="bi bi-clipboard-check text-primary fs-4"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">NamaProject</h5>
                <small class="text-muted">todolist@email.com</small>
            </div>
        </div>
        <button class="btn btn-light rounded-circle p-1" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-three-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear me-2 text-secondary"></i>Pengaturan</a></li>
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-question-circle me-2 text-secondary"></i>Bantuan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>
        </ul>
    </div>

    <nav class="nav-menu p-3">
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link rounded-pill d-flex align-items-center py-2 px-3 text-secondary" href="{{ route('home') }}">
                    <i class="bi bi-house-door me-3 fs-5"></i>
                    <span class="nav-link-text">Beranda</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill d-flex align-items-center py-2 px-3 text-primary bg-primary bg-opacity-10 active" href="{{ route('tasks.index') }}">
                    <i class="bi bi-list-check me-3 fs-5"></i>
                    <span class="nav-link-text">Tugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill d-flex align-items-center py-2 px-3 text-secondary" href="{{ route('profile') }}">
                    <i class="bi bi-person me-3 fs-5"></i>
                    <span class="nav-link-text">Profil</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer p-3 mt-auto">
        @auth
            <!-- Authentication Links -->
        @else
            <div class="d-grid gap-2">
                <a class="btn btn-primary rounded-pill">Login</a>
                <a class="btn btn-outline-primary rounded-pill">Register</a>
            </div>
        @endauth
    </div>
</aside>