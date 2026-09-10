<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Clinic Admin' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('admin/assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/main.css') }}">
    @stack('styles')
</head>

<body>
    @include('admin.partials.sidebar')

    <div class="main-wrapper">
        @include('admin.partials.navbar')

        <main class="p-4 p-xl-5">
            {{ $slot }}
        </main>

        <footer class="footer-custom">
            <div class="footer-left">
                <span class="footer-logo"><i class="bi bi-heart-pulse-fill"></i> Clinic Admin</span>
                <span class="footer-separator">|</span>
                <span class="footer-copy">&copy; {{ now()->year }} Clinic System</span>
            </div>
        </footer>
    </div>

    @flasher_render
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>
