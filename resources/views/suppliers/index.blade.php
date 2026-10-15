@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="heading">
    <div>
        <h1>Daftar Supplier</h1>
        <p class="muted">Mitra pemasok unit dan aksesoris Galeri Laptop.</p>
    </div>
    <a class="btn primary" href="{{ route('suppliers.create') }}">+ Tambah Supplier</a>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                <tr>
                    <td><b>{{ $supplier->name }}</b></td>
                    <td>{{ $supplier->phone ?: '-' }}</td>
                    <td>{{ $supplier->email ?: '-' }}</td>
                    <td>{{ $supplier->address ?: '-' }}</td>
                    <td>
                        <a href="{{ route('suppliers.edit', $supplier) }}">Edit</a> · 
                        <form class="inline" method="POST" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link text-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data supplier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
