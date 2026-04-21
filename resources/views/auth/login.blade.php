@extends('auth.layout')

@section('title', 'Login')
@section('heading', 'Masuk ke Akun')
@section('subtitle', 'Login user maupun admin sekarang menggunakan email aktif Anda.')

@section('content')
    <form action="{{ route('proses.login') }}" method="POST" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            </div>
            @error('email')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            @error('password')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-row">
            <label class="checkbox-wrap">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <span>Ingat saya</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-link">Lupa password?</a>
        </div>

        <button type="submit" class="auth-button">Login</button>
    </form>

    <p class="auth-switch">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
    </p>
@endsection
