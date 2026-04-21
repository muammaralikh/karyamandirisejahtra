@extends('auth.layout')

@section('title', 'Register')
@section('heading', 'Buat Akun Baru')
@section('subtitle', 'Daftar dengan email aktif agar proses login dan reset password tersinkron.')

@section('content')
    <form action="{{ route('proses.register') }}" method="POST" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <div class="input-wrap">
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus>
            </div>
            @error('name')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
            </div>
            @error('email')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <div class="input-wrap">
                <i class="fas fa-at"></i>
                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Opsional, otomatis dibuat jika kosong">
            </div>
            @error('username')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>
            @error('password')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="input-wrap">
                <i class="fas fa-shield-alt"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
            </div>
        </div>

        <button type="submit" class="auth-button">Daftar</button>
    </form>

    <p class="auth-switch">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login di sini</a>
    </p>
@endsection
