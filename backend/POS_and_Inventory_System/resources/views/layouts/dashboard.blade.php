<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'POS and Inventory System' }} | POS and Inventory System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-dashboard-details.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-signed-in.css') }}">
</head>
<body>
    @include('partials.header')

    <main>

        @include('partials.dashboard-menu')

        @yield('content')
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    @include('partials.footer')

</body>