@extends('layouts.app')

@section('title', $supplier->exists ? 'Edit Supplier' : 'Tambah Supplier')

@section('content')
<div class="heading">
    <div>
        <h1>{{ $supplier->exists ? 'Edit Data Supplier' : 'Tambah Supplier Baru' }}</h1>
        <p class="muted">Informasi kontak dan alamat supplier rekanan.</p>
    </div>
    <a class="btn" href="{{ route('suppliers.index') }}">Kembali</a>
</div>

<div class="panel form-panel">
    <form method="POST" action="{{ $supplier->exists ? route('suppliers.update', $supplier) : route('suppliers.store') }}">
        @csrf
        @if($supplier->exists)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Nama Supplier <span class="required">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $supplier->name) }}" required>
            @error('name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" placeholder="08xxxxxxxxxx">
            @error('phone')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $supplier->email) }}" placeholder="email@supplier.com">
            @error('email')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
            @error('address')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn primary">
                {{ $supplier->exists ? 'Perbarui Supplier' : 'Simpan Supplier' }}
            </button>
            <a class="btn" href="{{ route('suppliers.index') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
