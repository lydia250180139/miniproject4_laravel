<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Galeri Laptop') — Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @if(auth()->check())
        <div class="shell">
            @include('layouts.navigation')

            <main>
                <header>
                    GALERI LAPTOP <span>INVENTORY MANAGEMENT SYSTEM</span>
                </header>
                <section>
                    @if(session('success'))
                        <x-alert type="success">
                            {{ session('success') }}
                        </x-alert>
                    @endif

                    @if($errors->any())
                        <x-alert type="error">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </x-alert>
                    @endif

                    @yield('content')
                </section>
            </main>
        </div>
    @else
        @yield('content')
    @endif
</body>
</html>
