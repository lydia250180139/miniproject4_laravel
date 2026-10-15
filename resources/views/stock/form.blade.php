@extends('layouts.app')

@section('title', 'Catat Transaksi Stok')

@section('content')
<div class="heading">
    <div>
        <h1>Catat Transaksi Mutasi Stok</h1>
        <p class="muted">Catat barang masuk dari supplier atau barang keluar untuk penjualan/distribusi.</p>
    </div>
    <a class="btn" href="{{ route('stock.index') }}">Kembali ke Riwayat</a>
</div>

<div class="panel form-panel">
    <form method="POST" action="{{ route('stock.store') }}">
        @csrf

        <div class="form-group">
            <label for="product_id">Pilih Produk <span class="required">*</span></label>
            <select id="product_id" name="product_id" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>
                        [{{ $p->sku }}] {{ $p->name }} — Stok saat ini: {{ $p->stock }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Jenis Transaksi <span class="required">*</span></label>
            <select id="type" name="type" required>
                <option value="IN" @selected(old('type') == 'IN')>Barang Masuk (IN) — Menambah Stok</option>
                <option value="OUT" @selected(old('type') == 'OUT')>Barang Keluar (OUT) — Mengurangi Stok</option>
            </select>
            @error('type')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantity">Jumlah Unit <span class="required">*</span></label>
            <input id="quantity" type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
            @error('quantity')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="note">Catatan Transaksi</label>
            <textarea id="note" name="note" rows="3" placeholder="Contoh: Penerimaan barang dari Supplier Sumber Teknologi">{{ old('note') }}</textarea>
            @error('note')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn primary">Simpan Transaksi Stok</button>
            <a class="btn" href="{{ route('stock.index') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
