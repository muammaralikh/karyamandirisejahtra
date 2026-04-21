@extends('auth.layout')

@section('title', 'Atur Ulang Password')
@section('heading', 'Atur Password Baru')
@section('subtitle', 'Gunakan password baru yang kuat agar akun tetap aman.')

@section('content')
    <form action="{{ route('password.update') }}" method="POST" class="auth-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email', $email) }}" placeholder="nama@email.com" required autofocus>
            </div>
            @error('email')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>
            @error('password')
                <small class="form-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="input-wrap">
                <i class="fas fa-shield-alt"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
            </div>
        </div>

        <button type="submit" class="auth-button">Simpan Password Baru</button>
    </form>
@endsection
