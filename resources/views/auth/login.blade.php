@extends('auth.layout')

@section('title', 'Login KMS')
@section('heading', 'Masuk ke Akun')
@section('subtitle', '')

@section('content')
    <form action="{{ route('proses.login') }}" method="POST" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="login">Email atau Username</label>
            <div class="input-wrap">
                <i class="fas fa-user-circle"></i>
                <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="masukkan email/username" required autofocus>
            </div>
            @error('login')
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
