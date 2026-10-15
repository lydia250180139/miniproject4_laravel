@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
<div class="heading">
    <div>
        <h1>Kategori Produk</h1>
        <p class="muted">Pengelompokan barang untuk mempermudah pencarian dan filter.</p>
    </div>
    <a class="btn primary" href="{{ route('categories.create') }}">+ Tambah Kategori</a>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td><b>{{ $category->name }}</b></td>
                    <td>{{ $category->description ?: '-' }}</td>
                    <td>{{ $category->products_count }} item</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">Edit</a> · 
                        <form class="inline" method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link text-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">Belum ada data kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $categories->links() }}
    </div>
</div>
@endsection
