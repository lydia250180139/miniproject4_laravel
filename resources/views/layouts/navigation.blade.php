<aside>
    <a class="brand" href="{{ route('dashboard') }}">
        G <span>GALERI LAPTOP</span>
    </a>

    @if(auth()->check())
        <div style="background: rgba(255, 255, 255, 0.08); padding: 12px; border-radius: 8px; margin-bottom: 24px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <div style="font-size: 10px; letter-spacing: 1px; color: #94a3b8; text-transform: uppercase;">User Aktif</div>
            <div style="font-weight: 700; color: #ffffff; font-size: 13px; margin: 2px 0 6px;">{{ auth()->user()->name }}</div>
            <span style="display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px; background: {{ auth()->user()->isAdmin() ? '#3b82f6' : '#10b981' }}; color: #ffffff;">
                ● {{ strtoupper(auth()->user()->role) }}
            </span>
        </div>
    @endif

    <p>MENU UTAMA</p>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        📊 Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        💻 Produk
    </a>
    <a href="{{ route('stock.index') }}" class="{{ request()->routeIs('stock.*') ? 'active' : '' }}">
        🔄 Transaksi Stok
    </a>

    <p style="margin-top: 20px;">KHUSUS ADMIN</p>
    <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
        📁 Kategori
        @if(auth()->check() && !auth()->user()->isAdmin())
            <span style="font-size: 9px; opacity: 0.6; float: right; background: rgba(239,68,68,0.2); padding: 1px 4px; border-radius: 4px;">Terkunci</span>
        @endif
    </a>
    <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
        🏢 Supplier
        @if(auth()->check() && !auth()->user()->isAdmin())
            <span style="font-size: 9px; opacity: 0.6; float: right; background: rgba(239,68,68,0.2); padding: 1px 4px; border-radius: 4px;">Terkunci</span>
        @endif
    </a>

    <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
        @csrf
        <button type="submit" class="logout-btn" style="width: 100%; text-align: left; padding: 10px 12px; border-radius: 8px; background: rgba(239, 68, 68, 0.15); color: #fca5a5; font-weight: 700; cursor: pointer; border: 1px solid rgba(239, 68, 68, 0.2);">
            🚪 Keluar (Logout)
        </button>
    </form>
</aside>
