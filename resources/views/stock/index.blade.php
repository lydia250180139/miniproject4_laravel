@extends('layouts.app')

@section('title', 'Transaksi Stok')

@section('content')
<div class="heading">
    <div>
        <h1>Riwayat Mutasi Stok</h1>
        <p class="muted">Catatan pergerakan barang masuk dan barang keluar.</p>
    </div>
    <a class="btn primary" href="{{ route('stock.create') }}">+ Catat Transaksi Stok</a>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jenis Mutasi</th>
                <th>Jumlah</th>
                <th>Petugas</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $m)
                <tr>
                    <td>{{ $m->created_at->format('d-m-Y H:i') }}</td>
                    <td><b>{{ $m->product?->sku ?? '' }}</b> — {{ $m->product?->name ?? 'Produk Dihapus' }}</td>
                    <td>
                        <span class="pill {{ $m->type === 'IN' ? 'pill-success' : 'pill-danger' }}">
                            {{ $m->type === 'IN' ? 'Barang Masuk (IN)' : 'Barang Keluar (OUT)' }}
                        </span>
                    </td>
                    <td><b>{{ $m->quantity }}</b> unit</td>
                    <td>{{ $m->user?->name ?? 'Administrator' }}</td>
                    <td>{{ $m->note ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Belum ada histori transaksi stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $movements->links() }}
    </div>
</div>
@endsection
