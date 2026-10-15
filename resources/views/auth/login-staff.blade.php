@extends('layouts.app')

@section('title', 'Login Staff Gudang')

@section('content')
<div class="login">
    <div class="login-info" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);">
        <div class="brand">G · GALERI LAPTOP</div>
        <div style="display: inline-block; background: rgba(52, 211, 153, 0.2); color: #a7f3d0; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; letter-spacing: 1px; margin-bottom: 24px; border: 1px solid rgba(52, 211, 153, 0.4);">
            PORTAL STAFF GUDANG & INVENTARIS
        </div>
        <h1>Operasional Stok.<br><em>Cepat & Akurat.</em></h1>
        <p>Login khusus Staff Gudang untuk mencatat transaksi barang masuk/keluar dan pemantauan stok laptop.</p>
        
        <div style="margin-top: 40px; padding: 14px; background: rgba(255, 255, 255, 0.05); border-radius: 8px; font-size: 12px; border-left: 3px solid #10b981;">
            📦 <b>Hak Akses Terbatas:</b> Staff berfokus pada pencatatan mutasi stok dan katalog barang.
        </div>
    </div>

    <form method="POST" action="{{ route('login.staff.post') }}">
        @csrf

        <div style="display: flex; gap: 8px; margin-bottom: 24px; background: #f1f5f9; padding: 4px; border-radius: 8px;">
            <a href="{{ route('login.admin') }}" style="flex: 1; text-align: center; padding: 8px 12px; border-radius: 6px; color: #64748b; font-weight: 600; font-size: 12px; text-decoration: none;">
                🔑 Portal Admin
            </a>
            <a href="{{ route('login.staff') }}" style="flex: 1; text-align: center; padding: 8px 12px; border-radius: 6px; background: #059669; color: #ffffff; font-weight: 700; font-size: 12px; text-decoration: none;">
                📦 Portal Staff
            </a>
        </div>

        <h2>Login Staff</h2>
        <p>Masukkan akun staff untuk mengelola transaksi stok harian.</p>

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
            <label for="username">Username Staff</label>
            <input id="username" name="username" value="{{ old('username') }}" placeholder="staff" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="primary" style="background: #059669;">
            Masuk sebagai Staff →
        </button>

        <div style="text-align: center; margin-top: 20px;">
            <small style="color: #64748b; font-size: 12px;">
                Demo Staff: <b>staff</b> / Password: <b>staff123</b>
            </small>
        </div>
    </form>
</div>
@endsection
