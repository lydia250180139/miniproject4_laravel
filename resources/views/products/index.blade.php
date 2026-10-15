@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="heading">
    <div>
        <h1>Daftar Produk</h1>
        <p class="muted">Kelola persediaan laptop, iPad, dan aksesoris Galeri Laptop.</p>
    </div>
    <div>
        @if(auth()->check() && auth()->user()->isAdmin())
            <a class="btn primary" href="{{ route('products.create') }}">+ Tambah Produk Baru</a>
        @else
            <span class="pill pill-warning" style="padding: 8px 12px; font-size: 11px;">
                🔒 Tambah/Edit Produk: Khusus Admin
            </span>
        @endif
    </div>
</div>

<div class="panel">
    <form class="filters" method="GET" action="{{ route('products.index') }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU produk...">
        
        <select name="category_id">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="sort">
            <option value="latest" @selected(request('sort', 'latest') == 'latest')>Urutkan: Terbaru</option>
            <option value="name_asc" @selected(request('sort') == 'name_asc')>Nama: A - Z</option>
            <option value="name_desc" @selected(request('sort') == 'name_desc')>Nama: Z - A</option>
            <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga: Termurah</option>
            <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga: Termahal</option>
            <option value="stock_asc" @selected(request('sort') == 'stock_asc')>Stok: Paling Sedikit</option>
            <option value="stock_desc" @selected(request('sort') == 'stock_desc')>Stok: Paling Banyak</option>
        </select>

        <button type="submit" class="btn">Filter</button>
        <a class="btn" href="{{ route('products.index') }}">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td><code>{{ $product->sku }}</code></td>
                    <td><b>{{ $product->name }}</b></td>
                    <td>{{ $product->category->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }} unit</td>
                    <td>
                        <span class="pill {{ $product->stock <= $product->minimum_stock ? 'pill-warning' : 'pill-success' }}">
                            {{ $product->stock_status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}">Detail</a>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            · <a href="{{ route('products.edit', $product) }}">Edit</a> · 
                            <form class="inline" method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link text-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 24px;">Belum ada data produk yang cocok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $products->links() }}
    </div>
</div>
@endsection
