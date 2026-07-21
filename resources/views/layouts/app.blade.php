<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIMBIS - Sistem Informasi Manajemen Bisnis' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SIMBIS Custom Mobile Theme -->
    <link rel="stylesheet" href="{{ asset('css/simbis.css') }}">

    @stack('styles')
</head>
<body>
    <div class="app-container">
        @if(!$hideHeader)
        <header class="app-header">
            <div class="d-flex align-items-center gap-2">
                @if($backUrl)
                    <a href="{{ $backUrl }}" class="header-icon text-decoration-none">
                        <i class="bi bi-arrow-left fs-5"></i>
                    </a>
                @endif
                <h1 class="header-title">{{ $title ?? 'SIMBIS' }}</h1>
            </div>
            @if(isset($headerAction))
                {{ $headerAction }}
            @else
                <a href="{{ route('akun.index') }}" class="header-icon text-decoration-none">
                    <i class="bi bi-person fs-5"></i>
                </a>
            @endif
        </header>
        @endif

        <main class="app-main flex-grow-1">
            {{ $slot }}
        </main>

        <x-bottom-nav :active="$activeNav" />
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
