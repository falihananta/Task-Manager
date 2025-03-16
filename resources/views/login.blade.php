@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Hero Section -->
        <div class="col-md-6 hero-section d-flex align-items-center justify-content-center">
            <div class="overlay"></div>
            <div class="hero-text">
                <h1>Masuk ke akun Anda untuk mengakses layanan lingkungan yang lebih bersih dan berkelanjutan.</h1>
            </div>
        </div>

        <!-- Login Section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center p-5">
            <div class="w-100" style="max-width: 400px;">
                <h2 class="mb-1">Selamat Datang!</h2>
                <p class="text-muted">di Website Dinas Lingkungan Hidup DKI Jakarta</p>

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="johndoe@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" id="password-input" name="password" class="form-control" placeholder="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <a href="#" class="text-decoration-none">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="btn btn-warning w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("toggle-password").addEventListener("click", function() {
        const passwordInput = document.getElementById("password-input");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    });
</script>

@endsection