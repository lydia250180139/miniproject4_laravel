@extends('layouts.app')

@section('title', 'Login Administrator')

@section('content')
<div class="login">
    <div class="login-info" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="brand">G · GALERI LAPTOP</div>
        <div style="display: inline-block; background: rgba(59, 130, 246, 0.2); color: #93c5fd; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; letter-spacing: 1px; margin-bottom: 24px; border: 1px solid rgba(59, 130, 246, 0.4);">
            PORTAL ADMINISTRATOR
        </div>
        <h1>Akses Penuh.<br><em>Manajemen Sistem.</em></h1>
        <p>Login khusus Administrator untuk mengelola produk, kategori, supplier, user, dan persetujuan stok.</p>
        
        <div style="margin-top: 40px; padding: 14px; background: rgba(255, 255, 255, 0.05); border-radius: 8px; font-size: 12px; border-left: 3px solid #3b82f6;">
            🔒 <b>Perhatian Keamanan:</b> Akun Staff gudang dilarang masuk melalui portal ini.
        </div>
    </div>

    <form method="POST" action="{{ route('login.admin.post') }}">
        @csrf

        <div style="display: flex; gap: 8px; margin-bottom: 24px; background: #f1f5f9; padding: 4px; border-radius: 8px;">
            <a href="{{ route('login.admin') }}" style="flex: 1; text-align: center; padding: 8px 12px; border-radius: 6px; background: #0f172a; color: #ffffff; font-weight: 700; font-size: 12px; text-decoration: none;">
                🔑 Portal Admin
            </a>
            <a href="{{ route('login.staff') }}" style="flex: 1; text-align: center; padding: 8px 12px; border-radius: 6px; color: #64748b; font-weight: 600; font-size: 12px; text-decoration: none;">
                📦 Portal Staff
            </a>
        </div>

        <h2>Login Administrator</h2>
        <p>Masukkan akun admin untuk mengelola seluruh sistem.</p>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        @error('username')
            <div class="alert alert-error" style="margin-bottom: 16px;">
                {{ $message }}
            </div>
        @enderror

        <div class="form-group">
            <label for="username">Username Admin</label>
            <input id="username" name="username" value="{{ old('username') }}" placeholder="admin" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="primary" style="background: #0f172a;">
            Masuk sebagai Admin →
        </button>

        <div style="text-align: center; margin-top: 20px;">
            <small style="color: #64748b; font-size: 12px;">
                Demo Admin: <b>admin</b> / Password: <b>admin123</b>
            </small>
        </div>
    </form>
</div>
@endsection
