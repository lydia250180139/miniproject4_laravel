@extends('layouts.app')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="heading">
    <div>
        <h1>{{ $product->exists ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
        <p class="muted">Silakan lengkapi formulir di bawah ini dengan benar.</p>
    </div>
    <a class="btn" href="{{ route('products.index') }}">Kembali ke Daftar</a>
</div>

<div class="panel form-panel">
    <form method="POST" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
        @csrf
        @if($product->exists)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="sku">SKU / Kode Produk <span class="required">*</span></label>
            <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Contoh: LPT-004" required>
            @error('sku')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">Nama Produk <span class="required">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Contoh: ASUS ZenBook 14 OLED" required>
            @error('name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Kategori <span class="required">*</span></label>
            <select id="category_id" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp) <span class="required">*</span></label>
            <input id="price" type="number" min="0" step="1000" name="price" value="{{ old('price', $product->price) }}" placeholder="0" required>
            @error('price')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok Awal / Berjalan <span class="required">*</span></label>
            <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
            @error('stock')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="minimum_stock">Minimum Stok Alert <span class="required">*</span></label>
            <input id="minimum_stock" type="number" min="0" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock ?? 3) }}" required>
            @error('minimum_stock')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk</label>
            <textarea id="description" name="description" rows="3" placeholder="Spesifikasi atau keterangan tambahan produk">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn primary">
                {{ $product->exists ? 'Perbarui Produk' : 'Simpan Produk' }}
            </button>
            <a class="btn" href="{{ route('products.index') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
