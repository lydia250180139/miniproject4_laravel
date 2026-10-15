<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Terlarang (Forbidden)</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .error-page-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            padding: 24px;
        }
        .error-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            max-width: 580px;
            width: 100%;
            padding: 40px;
            text-align: center;
        }
        .error-badge {
            display: inline-block;
            background: #fee2e2;
            color: #991b1b;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 1.5px;
            padding: 6px 16px;
            border-radius: 9999px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }
        .error-code {
            font-size: 72px;
            font-weight: 900;
            color: #b91c1c;
            line-height: 1;
            margin: 0 0 12px;
            font-family: 'Manrope', sans-serif;
        }
        .error-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 16px;
        }
        .error-desc {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 24px;
        }
        .role-notice {
            background: #f8fafc;
            border-left: 4px solid #ef4444;
            padding: 14px;
            text-align: left;
            border-radius: 6px;
            font-size: 13px;
            color: #334155;
            margin-bottom: 28px;
        }
        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="error-page-container">
        <div class="error-card">
            <span class="error-badge">PERINGATAN KEAMANAN SISTEM</span>
            <div class="error-code">403</div>
            <h1 class="error-title">Akses Terlarang (Forbidden)</h1>
            <p class="error-desc">
                {{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses yang memadai untuk membuka halaman atau menjalankan perintah ini.' }}
            </p>

            @if(auth()->check())
                <div class="role-notice">
                    <strong>Informasi Akun Anda:</strong><br>
                    Nama: <b>{{ auth()->user()->name }}</b> (<code>{{ auth()->user()->username }}</code>)<br>
                    Role Aktif: <b style="text-transform: uppercase; color: {{ auth()->user()->isAdmin() ? '#2563eb' : '#059669' }};">[{{ auth()->user()->role }}]</b><br>
                    <small style="color: #64748b;">Halaman/fitur ini memerlukan hak wewenang <b>Administrator</b>.</small>
                </div>
            @endif

            <div class="error-actions">
                <a href="{{ route('dashboard') }}" class="btn primary" style="padding: 12px 24px; font-size: 14px;">
                    Kembali ke Dashboard
                </a>
                <a href="javascript:history.back()" class="btn" style="padding: 12px 20px; font-size: 14px;">
                    Kembali ke Halaman Sebelumnya
                </a>
            </div>
        </div>
    </div>
</body>
</html>
