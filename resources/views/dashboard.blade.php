@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard Inventaris</h1>
<p class="muted">Ringkasan Manajemen Persediaan Galeri Laptop.</p>

<div class="stats">
    <div>
        <small>Total Produk</small>
        <strong>{{ $products }}</strong>
    </div>
    <div>
        <small>Kategori</small>
        <strong>{{ $categories }}</strong>
    </div>
    <div>
        <small>Supplier</small>
        <strong>{{ $suppliers }}</strong>
    </div>
    <div>
        <small>Stok Menipis</small>
        <strong style="color: #b7791f;">{{ $low }}</strong>
    </div>
</div>

<div class="panel">
    <div class="heading">
        <h2>Aktivitas Transaksi Stok Terbaru</h2>
        <a class="btn" href="{{ route('stock.index') }}">Lihat Semua Riwayat</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Petugas</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent as $m)
                <tr>
                    <td><b>{{ $m->product?->name ?? 'Produk Dihapus' }}</b></td>
                    <td>
                        <span class="pill {{ $m->type === 'IN' ? 'pill-success' : 'pill-danger' }}">
                            {{ $m->type === 'IN' ? 'Barang Masuk (IN)' : 'Barang Keluar (OUT)' }}
                        </span>
                    </td>
                    <td>{{ $m->quantity }} unit</td>
                    <td>{{ $m->user?->name ?? 'Administrator' }}</td>
                    <td>{{ $m->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Belum ada transaksi mutasi stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
