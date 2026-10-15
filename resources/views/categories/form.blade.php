@extends('layouts.app')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="heading">
    <div>
        <h1>{{ $category->exists ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
        <p class="muted">Kelola kelompok kategori barang.</p>
    </div>
    <a class="btn" href="{{ route('categories.index') }}">Kembali</a>
</div>

<div class="panel form-panel">
    <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
        @csrf
        @if($category->exists)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Nama Kategori <span class="required">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn primary">
                {{ $category->exists ? 'Perbarui Kategori' : 'Simpan Kategori' }}
            </button>
            <a class="btn" href="{{ route('categories.index') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
