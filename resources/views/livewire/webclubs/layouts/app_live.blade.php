<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>{{ $title ?? tenantName() }}</title>
    <meta name="description" content="{{ $description ?? 'Club deportivo ' . tenantName() . '. Formando campeones, excelencia en cada entrenamiento.' }}">
    <meta name="keywords" content="{{ $keywords ?? tenantName() . ', club deportivo, fútbol, entrenamiento, equipos, jugadores' }}">
    <meta name="author" content="{{ tenantName() }}">
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
    <meta property="og:title" content="{{ $ogTitle ?? $title ?? tenantName() }}">
    <meta property="og:description" content="{{ $ogDescription ?? $description ?? 'Club deportivo ' . tenantName() }}">
    <meta property="og:image" content="{{ $ogImage ?? tenantLogo() }}">
    <meta property="og:site_name" content="{{ tenantName() }}">
    <meta property="og:locale" content="es_ES">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}">
    <meta name="twitter:url" content="{{ $twitterUrl ?? url()->current() }}">
    <meta name="twitter:title" content="{{ $twitterTitle ?? $title ?? tenantName() }}">
    <meta name="twitter:description" content="{{ $twitterDescription ?? $description ?? 'Club deportivo ' . tenantName() }}">
    <meta name="twitter:image" content="{{ $twitterImage ?? tenantLogo() }}">
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="{{ currentSchool()?->primary_color ?? '#1E40AF' }}">
    <meta name="msapplication-TileColor" content="{{ currentSchool()?->primary_color ?? '#1E40AF' }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ tenantLogo() }}">
    <link rel="apple-touch-icon" href="{{ tenantLogo() }}">
    
    @stack('meta')
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- GSAP & Plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: {{ currentSchool()?->primary_color ?? '#1E40AF' }};
            --color-secondary: {{ currentSchool()?->secondary_color ?? '#10B981' }};
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        /* Clases utility para usar los colores dinámicos */
        .bg-primary { background-color: var(--color-primary) !important; }
        .bg-secondary { background-color: var(--color-secondary) !important; }
        .text-primary { color: var(--color-primary) !important; }
        .text-secondary { color: var(--color-secondary) !important; }
        .border-primary { border-color: var(--color-primary) !important; }
        .border-secondary { border-color: var(--color-secondary) !important; }
        .hover\:bg-primary:hover { background-color: var(--color-primary) !important; }
        .hover\:bg-secondary:hover { background-color: var(--color-secondary) !important; }
        .hover\:text-primary:hover { color: var(--color-primary) !important; }
        .hover\:text-secondary:hover { color: var(--color-secondary) !important; }
        
        /* Page Loader */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        .page-loader::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ tenantLogo() }}') center center no-repeat;
            background-size: 400px;
            opacity: 0.08;
            z-index: -1;
        }

        .loader-progress {
            width: 50%;
            height: 6px;
            background: rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 3px;
            position: relative;
            z-index: 1;
        }

        .loader-progress-bar {
            width: 0%;
            height: 100%;
            background: var(--color-primary);
            transition: width 0.1s ease;
        }
    </style>
    
    @stack('styles')
    <!-- Cropper.js (usado en inscripción de equipos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        .step-anim { animation: stepSlideIn 0.22s ease-out both; }
        @keyframes stepSlideIn {
            from { opacity: 0; transform: translateX(16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased bg-[#080c14] text-gray-100">
    
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader-progress">
            <div class="loader-progress-bar"></div>
        </div>
    </div>
    
    {{-- @include('livewire.webclubs.layouts.nav-bar') --}}

    <!-- Contenido Principal -->
    @isset($slot)
        {{ $slot }}
    @else
        @yield('content')
    @endisset

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Page Loader Animation
        const loader = document.querySelector('.page-loader');
        const loaderProgress = document.querySelector('.loader-progress-bar');

        // Fallback timeout
        setTimeout(() => {
            if (loader && loader.style.display !== 'none') {
                loader.style.display = 'none';
            }
        }, 3000);

        if (typeof gsap !== 'undefined') {
            const loaderTl = gsap.timeline();

            loaderTl
                .to(loaderProgress, {
                    width: '100%',
                    duration: 1.5,
                    ease: 'power2.inOut',
                    delay: 0.2
                })
                .to(loader, {
                    opacity: 0,
                    duration: 0.3,
                    ease: 'power2.inOut',
                    onComplete: () => {
                        loader.style.display = 'none';
                    }
                });
        } else {
            // Fallback sin GSAP
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }, 1500);
        }
        
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
        
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')

    <!-- Cropper.js JS (used on team registration page) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    @include('livewire.webclubs.layouts.footer')

    @livewireScripts

</body>
</html>