@extends('auth.layout')

@section('title', 'Lupa Password')
@section('heading', 'Reset Password')
@section('subtitle', 'Masukkan email akun. Link reset password akan dikirim otomatis ke email tersebut.')

@section('content')
    <form action="{{ route('password.email') }}" method="POST" class="auth-form">
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

        <button type="submit" class="auth-button">Kirim Link Reset</button>
    </form>

    <p class="auth-switch">
        Sudah ingat password?
        <a href="{{ route('login') }}">Kembali ke login</a>
    </p>
@endsection
