<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'POS and Inventory System' }} | POS and Inventory System</title>
    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main>

        @include('partials.dashboard-menu')

        @yield('content')
        
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>