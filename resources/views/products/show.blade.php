@extends('layouts.app')

@section('title', 'Detail Produk — ' . $product->name)

@section('content')
<div class="heading">
    <div>
        <h1>{{ $product->name }}</h1>
        <p class="muted">Detail informasi produk dan histori mutasi stok.</p>
    </div>
    <div>
        <a class="btn" href="{{ route('products.edit', $product) }}">Edit Produk</a>
        <a class="btn" href="{{ route('products.index') }}">Kembali</a>
    </div>
</div>

<div class="panel">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div>
            <span class="muted">SKU:</span>
            <p><b><code>{{ $product->sku }}</code></b></p>
        </div>
        <div>
            <span class="muted">Kategori:</span>
            <p><b>{{ $product->category->name }}</b></p>
        </div>
        <div>
            <span class="muted">Harga:</span>
            <p><b>Rp {{ number_format($product->price, 0, ',', '.') }}</b></p>
        </div>
        <div>
            <span class="muted">Stok Saat Ini:</span>
            <p><b>{{ $product->stock }} unit</b> (Min: {{ $product->minimum_stock }})</p>
        </div>
        <div>
            <span class="muted">Status Persediaan:</span>
            <p>
                <span class="pill {{ $product->stock <= $product->minimum_stock ? 'pill-warning' : 'pill-success' }}">
                    {{ $product->stock_status }}
                </span>
            </p>
        </div>
    </div>

    <div>
        <span class="muted">Deskripsi:</span>
        <p>{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
    </div>

    <hr style="margin: 24px 0; border: none; border-top: 1px solid var(--border, #e2e8f0);">

    <h2>Histori Mutasi Stok</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Petugas</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($product->movements as $m)
                <tr>
                    <td>{{ $m->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <span class="pill {{ $m->type === 'IN' ? 'pill-success' : 'pill-danger' }}">
                            {{ $m->type === 'IN' ? 'Barang Masuk (IN)' : 'Barang Keluar (OUT)' }}
                        </span>
                    </td>
                    <td><b>{{ $m->quantity }}</b> unit</td>
                    <td>{{ $m->user?->name ?? 'Sistem' }}</td>
                    <td>{{ $m->note ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Belum ada riwayat pergerakan stok untuk produk ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
