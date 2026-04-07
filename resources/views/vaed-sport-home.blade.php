<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
        <meta name="theme-color" content="#000000">

        <title>VAED Sport - Ropa Deportiva Personalizada para tu Club</title>

        <meta name="description" content="Ropa deportiva personalizada con el escudo de tu club. Camisetas, chándales, mochilas y más. Tu club gana entre un 5-10% de cada venta.">
        <meta name="robots" content="index, follow">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            body { font-family: 'Inter', sans-serif; margin: 0; background: #000; color: #fff; overflow-x: hidden; }

            /* ===== Announcement Bar ===== */
            .announcement-bar {
                background: #000;
                color: #fff;
                text-align: center;
                padding: 8px 16px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                border-bottom: 1px solid #222;
            }

            /* ===== Navbar ===== */
            .vs-nav {
                position: sticky;
                top: 0;
                z-index: 100;
                background: #fff;
                border-bottom: 1px solid #e5e5e5;
                transition: box-shadow 0.3s;
            }
            .vs-nav.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
            .vs-nav-inner {
                max-width: 1440px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 24px;
                height: 60px;
            }
            .vs-nav-logo {
                display: flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
                color: #000;
            }
            .vs-nav-logo img { height: 36px; }
            .vs-nav-logo span { font-size: 20px; font-weight: 900; letter-spacing: -0.5px; text-transform: uppercase; }
            .vs-nav-links { display: flex; gap: 32px; align-items: center; }
            .vs-nav-links a {
                color: #000;
                text-decoration: none;
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 6px 0;
                border-bottom: 3px solid transparent;
                transition: border-color 0.2s;
            }
            .vs-nav-links a:hover { border-bottom-color: #000; }
            .vs-nav-links a.active { border-bottom-color: #000; }
            .vs-nav-actions { display: flex; align-items: center; gap: 16px; }
            .vs-nav-actions a {
                color: #000;
                text-decoration: none;
                font-size: 14px;
                font-weight: 600;
                padding: 8px 20px;
                border-radius: 0;
                transition: all 0.2s;
            }
            .vs-btn-dark {
                background: #000 !important;
                color: #fff !important;
                font-weight: 700 !important;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 13px !important;
            }
            .vs-btn-dark:hover { background: #333 !important; }

            /* ===== Mobile nav toggle ===== */
            .vs-nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
            .vs-nav-mobile-auth { display: none; }
            @media (max-width: 768px) {
                .vs-nav-links { display: none; }
                .vs-nav-toggle { display: block; }
                .vs-nav-links.open {
                    display: flex;
                    flex-direction: column;
                    position: absolute;
                    top: 60px;
                    left: 0;
                    right: 0;
                    background: #fff;
                    padding: 16px 24px;
                    border-bottom: 1px solid #e5e5e5;
                    gap: 0;
                    z-index: 99;
                }
                .vs-nav-links.open a { padding: 14px 0; border-bottom: 1px solid #f0f0f0; }
                .vs-nav-links.open .vs-nav-mobile-auth {
                    display: block;
                    background: #000;
                    color: #fff !important;
                    text-align: center;
                    padding: 16px 24px !important;
                    margin-top: 14px;
                    border-bottom: none !important;
                    border-radius: 8px;
                    font-weight: 700;
                    font-size: 15px !important;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                .vs-nav-actions { display: none; }
            }

            /* ===== Hero Banner ===== */
            .vs-hero {
                position: relative;
                width: 100%;
                height: 85vh;
                min-height: 500px;
                max-height: 900px;
                overflow: hidden;
                background: #111;
            }
            .vs-hero-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            .vs-hero-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0,0,0,0.70);
            }
            .vs-hero-content {
                position: absolute;
                bottom: 60px;
                left: 40px;
                right: 40px;
                z-index: 5;
            }
            .vs-hero-tag {
                display: inline-block;
                background: #fff;
                color: #000;
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 2px;
                padding: 6px 14px;
                margin-bottom: 16px;
            }
            .vs-hero h1 {
                font-size: clamp(32px, 6vw, 72px);
                font-weight: 900;
                line-height: 1;
                margin: 0 0 16px;
                text-transform: uppercase;
                letter-spacing: -1px;
            }
            .vs-hero p {
                font-size: 16px;
                color: rgba(255,255,255,0.85);
                max-width: 500px;
                line-height: 1.5;
                margin: 0 0 28px;
            }
            .vs-hero-btn {
                display: inline-block;
                background: #fff;
                color: #000;
                font-weight: 800;
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 1px;
                padding: 14px 36px;
                text-decoration: none;
                transition: all 0.2s;
                border: none;
                cursor: pointer;
            }
            .vs-hero-btn:hover { background: #000; color: #fff; }

            /* ===== Category Grid (Adidas-style bento) ===== */
            .vs-section { padding: 0; }
            .vs-section-title {
                font-size: 28px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: -0.5px;
                padding: 40px 40px 24px;
                margin: 0;
                color: #000;
            }
            .vs-cat-grid {
                display: grid;
                gap: 4px;
                padding: 0 4px 4px;
            }
            .vs-cat-grid-2 { grid-template-columns: 1fr 1fr; }
            .vs-cat-grid-3 { grid-template-columns: 1fr 1fr 1fr; }
            .vs-cat-card {
                position: relative;
                overflow: hidden;
                cursor: pointer;
                aspect-ratio: 3/4;
                background: #111;
            }
            .vs-cat-card.wide { aspect-ratio: 16/9; }
            .vs-cat-card.tall { aspect-ratio: 2/3; grid-row: span 2; }
            .vs-cat-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }
            .vs-cat-card:hover img { transform: scale(1.05); }
            .vs-cat-card-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 50%);
            }
            .vs-cat-card-content {
                position: absolute;
                bottom: 24px;
                left: 24px;
                right: 24px;
                z-index: 2;
            }
            .vs-cat-card h3 {
                font-size: 22px;
                font-weight: 800;
                text-transform: uppercase;
                margin: 0 0 8px;
                color: #fff;
                letter-spacing: -0.3px;
            }
            .vs-cat-card-btn {
                display: inline-block;
                background: #fff;
                color: #000;
                font-size: 12px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 1px;
                padding: 10px 24px;
                text-decoration: none;
                transition: all 0.2s;
            }
            .vs-cat-card-btn:hover { background: #000; color: #fff; }

            @media (max-width: 768px) {
                .vs-cat-grid-3 { grid-template-columns: 1fr; }
                .vs-cat-grid-2 { grid-template-columns: 1fr; }
                .vs-cat-card { aspect-ratio: 4/5; }
                .vs-cat-card.wide { aspect-ratio: 4/3; }
                .vs-cat-card.tall { grid-row: span 1; aspect-ratio: 4/5; }
                .vs-hero-content { bottom: 30px; left: 20px; right: 20px; }
                .vs-section-title { padding: 30px 20px 18px; font-size: 22px; }
            }

            /* ===== Product Carousel ===== */
            .vs-products-section { background: #fff; padding: 50px 0 60px; }
            .vs-products-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 40px 24px;
            }
            .vs-products-header h2 { font-size: 28px; font-weight: 900; text-transform: uppercase; color: #000; margin: 0; }
            .vs-products-scroll-wrap { position: relative; }
            .vs-products-track {
                display: flex;
                gap: 4px;
                overflow-x: auto;
                scroll-behavior: smooth;
                scrollbar-width: none;
                padding: 0 40px;
            }
            .vs-products-track::-webkit-scrollbar { display: none; }
            .vs-product-card {
                flex: 0 0 300px;
                background: #f5f5f5;
                cursor: pointer;
                transition: transform 0.3s;
                position: relative;
            }
            .vs-product-card:hover { transform: translateY(-4px); }
            .vs-product-img-wrap {
                aspect-ratio: 3/4;
                overflow: hidden;
                background: #e8e8e8;
                position: relative;
            }
            .vs-product-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s;
            }
            .vs-product-card:hover .vs-product-img-wrap img { transform: scale(1.06); }
            .vs-product-badge {
                position: absolute;
                top: 12px;
                left: 12px;
                background: #000;
                color: #fff;
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                padding: 4px 10px;
                letter-spacing: 0.5px;
            }
            .vs-product-info { padding: 16px; }
            .vs-product-info h4 { font-size: 14px; font-weight: 700; color: #000; margin: 0 0 4px; }
            .vs-product-info .vs-product-type { font-size: 13px; color: #767677; margin: 0 0 8px; }
            .vs-product-info .vs-product-price { font-size: 15px; font-weight: 800; color: #000; }
            .vs-product-info .vs-product-club { font-size: 12px; color: #10b981; font-weight: 700; margin-top: 4px; }

            .vs-scroll-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: #fff;
                border: 1px solid #e5e5e5;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            .vs-scroll-btn:hover { background: #000; color: #fff; border-color: #000; }
            .vs-scroll-btn.prev { left: 12px; }
            .vs-scroll-btn.next { right: 12px; }

            @media (max-width: 768px) {
                .vs-product-card { flex: 0 0 230px; }
                .vs-products-track { padding: 0 20px; }
                .vs-products-header { padding: 0 20px 18px; }
                .vs-products-header h2 { font-size: 22px; }
                .vs-scroll-btn { display: none; }
            }

            /* ===== Full-width banner ===== */
            .vs-banner {
                position: relative;
                width: 100%;
                overflow: hidden;
                background: #111;
            }
            .vs-banner img {
                width: 100%;
                height: 60vh;
                min-height: 400px;
                object-fit: cover;
                display: block;
            }
            .vs-banner-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
            }
            .vs-banner-content {
                position: absolute;
                top: 50%;
                left: 40px;
                transform: translateY(-50%);
                max-width: 500px;
                z-index: 5;
            }
            @media (max-width: 768px) {
                .vs-banner-content { left: 20px; right: 20px; }
                .vs-banner img { height: 50vh; min-height: 350px; }
            }

            /* ===== Features bar ===== */
            .vs-features {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1px;
                background: #111;
            }
            .vs-feature-item {
                background: #000;
                padding: 40px 30px;
                text-align: center;
            }
            .vs-feature-icon { font-size: 32px; margin-bottom: 12px; }
            .vs-feature-title { font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
            .vs-feature-desc { font-size: 13px; color: #999; line-height: 1.4; }
            @media (max-width: 768px) {
                .vs-features { grid-template-columns: repeat(2, 1fr); }
                .vs-feature-item { padding: 24px 16px; }
            }

            /* ===== How it works ===== */
            .vs-how { background: #fff; color: #000; padding: 80px 40px; }
            .vs-how h2 { font-size: 36px; font-weight: 900; text-transform: uppercase; text-align: center; margin: 0 0 60px; }
            .vs-how-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px; max-width: 1100px; margin: 0 auto; }
            .vs-how-step { text-align: center; }
            .vs-how-num {
                width: 60px;
                height: 60px;
                border: 3px solid #000;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                font-weight: 900;
                margin: 0 auto 20px;
            }
            .vs-how-step h3 { font-size: 18px; font-weight: 800; text-transform: uppercase; margin: 0 0 10px; }
            .vs-how-step p { font-size: 15px; color: #555; line-height: 1.6; }
            @media (max-width: 768px) {
                .vs-how { padding: 50px 20px; }
                .vs-how h2 { font-size: 26px; margin-bottom: 40px; }
                .vs-how-grid { grid-template-columns: 1fr; gap: 36px; }
            }

            /* ===== CTA banner ===== */
            .vs-cta {
                background: #000;
                text-align: center;
                padding: 80px 40px;
            }
            .vs-cta h2 { font-size: 40px; font-weight: 900; text-transform: uppercase; margin: 0 0 16px; }
            .vs-cta p { font-size: 16px; color: #999; max-width: 600px; margin: 0 auto 32px; line-height: 1.5; }
            .vs-cta-btn {
                display: inline-block;
                background: #fff;
                color: #000;
                font-weight: 800;
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 1px;
                padding: 16px 48px;
                text-decoration: none;
                transition: all 0.2s;
            }
            .vs-cta-btn:hover { background: #10b981; color: #fff; }

            /* ===== Footer ===== */
            .vs-footer {
                background: #111;
                padding: 60px 40px;
                border-top: 1px solid #222;
            }
            .vs-footer-inner {
                max-width: 1440px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
                gap: 40px;
            }
            .vs-footer-brand p { color: #666; font-size: 14px; line-height: 1.6; margin-top: 12px; }
            .vs-footer-col h4 { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 16px; }
            .vs-footer-col a { display: block; color: #888; font-size: 13px; text-decoration: none; padding: 4px 0; transition: color 0.2s; }
            .vs-footer-col a:hover { color: #fff; }
            .vs-footer-bottom {
                max-width: 1440px;
                margin: 0 auto;
                padding-top: 30px;
                margin-top: 30px;
                border-top: 1px solid #222;
                text-align: center;
                color: #555;
                font-size: 13px;
            }
            @media (max-width: 768px) {
                .vs-footer-inner { grid-template-columns: 1fr 1fr; }
                .vs-cta h2 { font-size: 28px; }
                .vs-cta { padding: 50px 20px; }
                .vs-footer { padding: 40px 20px; }
            }

            /* ===== Animations ===== */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .vs-animate { opacity: 0; }
            .vs-animated { animation: fadeInUp 0.6s ease forwards; }

            /* ===== Marquee ===== */
            .vs-marquee {
                background: #10b981;
                color: #fff;
                padding: 12px 0;
                overflow: hidden;
                white-space: nowrap;
            }
            .vs-marquee-track {
                display: inline-flex;
                animation: marqueeScroll 30s linear infinite;
            }
            .vs-marquee-item {
                font-size: 13px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 2px;
                padding: 0 40px;
            }
            @keyframes marqueeScroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }

            /* ===== Lookbook grid ===== */
            .vs-lookbook {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr 1fr;
                gap: 4px;
                padding: 4px;
                height: 100vh;
                min-height: 600px;
                max-height: 900px;
            }
            .vs-lookbook-item {
                position: relative;
                overflow: hidden;
                background: #111;
            }
            .vs-lookbook-item.featured { grid-row: span 2; }
            .vs-lookbook-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }
            .vs-lookbook-item:hover img { transform: scale(1.04); }
            .vs-lookbook-label {
                position: absolute;
                bottom: 20px;
                left: 20px;
                background: #fff;
                color: #000;
                padding: 10px 20px;
                font-size: 13px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 1px;
                text-decoration: none;
                transition: all 0.2s;
            }
            .vs-lookbook-label:hover { background: #000; color: #fff; }
            @media (max-width: 768px) {
                .vs-lookbook { grid-template-columns: 1fr; grid-template-rows: auto; height: auto; min-height: auto; max-height: none; }
                .vs-lookbook-item { aspect-ratio: 4/5; }
                .vs-lookbook-item.featured { grid-row: span 1; }
            }

            /* ===== Product Lightbox ===== */
            .vs-lightbox {
                display: none;
                position: fixed;
                inset: 0;
                z-index: 9999;
                background: rgba(0,0,0,0.85);
                align-items: center;
                justify-content: center;
                cursor: zoom-out;
                padding: 24px;
            }
            .vs-lightbox.open { display: flex; }
            .vs-lightbox img {
                max-width: 90vw;
                max-height: 90vh;
                object-fit: contain;
                border-radius: 4px;
                box-shadow: 0 8px 40px rgba(0,0,0,0.5);
                animation: vsLightboxIn 0.25s ease;
            }
            .vs-lightbox-close {
                position: absolute;
                top: 20px;
                right: 24px;
                width: 44px;
                height: 44px;
                background: #fff;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                font-weight: 900;
                color: #000;
                transition: transform 0.2s;
            }
            .vs-lightbox-close:hover { transform: scale(1.1); }
            @keyframes vsLightboxIn {
                from { opacity: 0; transform: scale(0.92); }
                to { opacity: 1; transform: scale(1); }
            }
            .vs-product-img-wrap { cursor: zoom-in; }
        </style>
    </head>
    <body>

        <!-- Announcement Bar -->
        <div class="announcement-bar">
           Para vaed no existe club pequeño — <strong>PERSONALIZA TU ROPA CON EL NIVEL DE DETALLE QUE MERECE</strong> 
        </div>

        <!-- Navigation -->
        <nav class="vs-nav" id="vsNav">
            <div class="vs-nav-inner">
                <a href="{{ route('home') }}" class="vs-nav-logo">
                    <img src="{{ asset('images/logos/logo_vaed.png') }}" alt="VAED Sport">
                    <span>VAED Sport</span>
                </a>

                <button class="vs-nav-toggle" id="navToggle" aria-label="Abrir menú">
                    <svg width="24" height="24" fill="none" stroke="#000" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M3 6h18M3 12h18M3 18h18"/>
                    </svg>
                </button>

                <div class="vs-nav-links" id="navLinks">
                    <a href="#colecciones">Colecciones</a>
                    <a href="#catalogo">Catálogo</a>
                    <a href="#como-funciona">Cómo Funciona</a>
                    <a href="{{ route('home') }}">VaedSaas</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="vs-nav-mobile-auth">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="vs-nav-mobile-auth">Iniciar Sesión</a>
                    @endauth
                </div>

                <div class="vs-nav-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="vs-btn-dark">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="vs-btn-dark">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- ===== HERO BANNER ===== -->
        <div class="vs-hero">
            <img src="{{ asset('images/public/prototipe-cdpuebla.png') }}" alt="Colección deportiva personalizada" class="vs-hero-img">
            <div class="vs-hero-overlay"></div>
            <div class="vs-hero-content">
                <div class="vs-hero-tag">Nueva Colección 2026</div>
                <h1>Viste a tu equipo<br>con tu identidad</h1>
                <p>Ropa deportiva profesional personalizada con el escudo de tu club. Calidad premium, diseño exclusivo.</p>
                <a href="#catalogo" class="vs-hero-btn">Explorar Colección</a>
            </div>
        </div>

        <!-- Green Marquee -->
        <div class="vs-marquee">
            <div class="vs-marquee-track">
                <span class="vs-marquee-item">Personalización con el escudo de tu club</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Tu club gana automáticamente con cada compra</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Personalización con detalles únicos de tu club</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Calidad premium a precios competitivos</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Personalización con el escudo de tu club</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Tu club gana automáticamente con cada compra</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Entregamos toda la ropa en tu club</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Buena calidad a precios competitivos</span>
                <span class="vs-marquee-item">•</span>
                <span class="vs-marquee-item">Compromiso con la fecha de entrega</span>
                <span class="vs-marquee-item">•</span>
            </div>
        </div>

        <!-- ===== CATEGORY GRID (Bento 2-col) ===== -->
        <section class="vs-section" style="background:#fff;" id="colecciones">
            <h2 class="vs-section-title">Explora por Categoría</h2>
            <div class="vs-cat-grid vs-cat-grid-2">
                <!-- Equipación de juego -->
                <div class="vs-cat-card vs-animate">
                    <img src="{{ asset('images/public/camiseta_united_jugador.png') }}" alt="Equipación de Juego">
                    <div class="vs-cat-card-overlay"></div>
                    <div class="vs-cat-card-content">
                        <h3>Equipación de Juego</h3>
                        <a href="#catalogo" class="vs-cat-card-btn">Ver Productos</a>
                    </div>
                </div>
                <!-- Entreno -->
                <div class="vs-cat-card vs-animate">
                    <img src="{{ asset('images/public/conjuntocdpuebla.jpg') }}" alt="Ropa de Entrenamiento">
                    <div class="vs-cat-card-overlay"></div>
                    <div class="vs-cat-card-content">
                        <h3>Ropa de Entrenamiento</h3>
                        <a href="#catalogo" class="vs-cat-card-btn">Ver Productos</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== LOOKBOOK (Bento asymmetric) ===== -->
        <div class="vs-lookbook">
            <div class="vs-lookbook-item featured vs-animate">
                <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Chándales">
                <a href="#catalogo" class="vs-lookbook-label">Chándales</a>
            </div>
            <div class="vs-lookbook-item vs-animate">
                <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" alt="Complementos y bolsas">
                <a href="#catalogo" class="vs-lookbook-label">Accesorios</a>
            </div>
            <div class="vs-lookbook-item vs-animate">
                <img src="{{ asset('images/public/conjuntocdpuebla.jpg') }}" alt="Todo el catálogo">
                <a href="#catalogo" class="vs-lookbook-label">Ver Todo</a>
            </div>
        </div>

        <!-- ===== PRODUCT CAROUSEL: Camisetas ===== -->
        <section class="vs-products-section" id="catalogo">
            <div class="vs-products-header">
                <h2>Camisetas de Juego</h2>
            </div>
            <div class="vs-products-scroll-wrap">
                <button class="vs-scroll-btn prev" data-target="track1" aria-label="Anterior">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="vs-products-track" id="track1">
                    <!-- Product 1 -->
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/products/camiseta_united_celeste.png') }}" alt="Camiseta Primera Equipación">
                            <span class="vs-product-badge">TOP Ventas</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>VAED 201 CELESTE</h4>
                            <p class="vs-product-type">Personalizada con tu escudo, publicidad y dorsal</p>
                            <p class="vs-product-price">22,00 €</p>
                            {{-- <p class="vs-product-club">+3,30 € para tu club</p> --}}
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/products/camiseta_racing_azul-marino.png') }}" alt="Camiseta Segunda Equipación">
                            <span class="vs-product-badge">Nuevo</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>VAED Portero 201 Royal Blue</h4>
                            <p class="vs-product-type">Diseño alternativo exclusivo</p>
                            <p class="vs-product-price">22,00 €</p>
                            {{-- <p class="vs-product-club">+3,30 € para tu club</p> --}}
                        </div>
                    </div>
                    <!-- Product 3 -->
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/products/portejo.png') }}" alt="Camiseta de portero">
                        </div>
                        <div class="vs-product-info">
                            <h4>VAED PORTERO SK-01 AMARILLO FLUOR</h4>
                            <p class="vs-product-type">Personalizada con tu escudo, publicidad y dorsal</p>
                            <p class="vs-product-price">18,00 €</p>
                            
                        </div>
                    </div>
                    <!-- Product 4 -->
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/conjuntocdpuebla.jpg') }}" alt="Camiseta Portero">
                            <span class="vs-product-badge">Especial</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>Camiseta Portero</h4>
                            <p class="vs-product-type">Protecciones acolchadas</p>
                            <p class="vs-product-price">26,00 €</p>
                            <p class="vs-product-club">+3,90 € para tu club</p>
                        </div>
                    </div>
                    <!-- Product 5 -->
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/conjuntocdpuebla.jpg') }}" alt="Pack Camiseta + Pantalón">
                        </div>
                        <div class="vs-product-info">
                            <h4>Pack Camiseta + Pantalón</h4>
                            <p class="vs-product-type">Equipación completa</p>
                            <p class="vs-product-price">35,00 €</p>
                            <p class="vs-product-club">+5,25 € para tu club</p>
                        </div>
                    </div>
                </div>
                <button class="vs-scroll-btn next" data-target="track1" aria-label="Siguiente">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </section>

        <!-- ===== FULL-WIDTH BANNER ===== -->
        <div class="vs-banner">
            <img src="{{ asset('images/public/soccer-ball-blurred-kids-soccer-team-with-coach-field.jpg') }}" alt="Personalización para tu equipo">
            <div class="vs-banner-overlay"></div>
            <div class="vs-banner-content">
                <div class="vs-hero-tag" style="margin-bottom:14px;">Personalización</div>
                <h1 style="font-size:clamp(28px,5vw,52px);font-weight:900;text-transform:uppercase;margin:0 0 14px;line-height:1.05;">
                    El escudo de tu club en cada prenda
                </h1>
                <p style="font-size:15px;color:rgba(255,255,255,0.8);margin:0 0 24px;line-height:1.5;">
                    Bordado o sublimado. Tú eliges, nosotros lo hacemos realidad. Sin costes extra de personalización.
                </p>
                <a href="#como-funciona" class="vs-hero-btn">Descubre Cómo</a>
            </div>
        </div>

        <!-- ===== PRODUCT CAROUSEL: Chándales ===== -->
        <section class="vs-products-section">
            <div class="vs-products-header">
                <h2>Chándales y Entreno</h2>
            </div>
            <div class="vs-products-scroll-wrap">
                <button class="vs-scroll-btn prev" data-target="track2" aria-label="Anterior">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="vs-products-track" id="track2">
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Chándal Completo">
                            <span class="vs-product-badge">Best Seller</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>Chándal Completo</h4>
                            <p class="vs-product-type">Chaqueta + Pantalón</p>
                            <p class="vs-product-price">45,00 €</p>
                            <p class="vs-product-club">+6,75 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Sudadera con capucha">
                        </div>
                        <div class="vs-product-info">
                            <h4>Sudadera con Capucha</h4>
                            <p class="vs-product-type">Forro interior afelpado</p>
                            <p class="vs-product-price">32,00 €</p>
                            <p class="vs-product-club">+4,80 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Pantalón Corto Entrenamiento">
                            <span class="vs-product-badge">Nuevo</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>Pantalón Corto Entreno</h4>
                            <p class="vs-product-type">Tejido ultraligero</p>
                            <p class="vs-product-price">16,00 €</p>
                            <p class="vs-product-club">+2,40 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Cortavientos">
                        </div>
                        <div class="vs-product-info">
                            <h4>Cortavientos Training</h4>
                            <p class="vs-product-type">Impermeable y transpirable</p>
                            <p class="vs-product-price">38,00 €</p>
                            <p class="vs-product-club">+5,70 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Polo Técnico">
                        </div>
                        <div class="vs-product-info">
                            <h4>Polo Staff Técnico</h4>
                            <p class="vs-product-type">Para cuerpo técnico</p>
                            <p class="vs-product-price">24,00 €</p>
                            <p class="vs-product-club">+3,60 € para tu club</p>
                        </div>
                    </div>
                </div>
                <button class="vs-scroll-btn next" data-target="track2" aria-label="Siguiente">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </section>

        <!-- ===== PRODUCT CAROUSEL: Accesorios ===== -->
        <section class="vs-products-section" style="background:#f5f5f5;">
            <div class="vs-products-header">
                <h2>Accesorios y Complementos</h2>
            </div>
            <div class="vs-products-scroll-wrap">
                <button class="vs-scroll-btn prev" data-target="track3" aria-label="Anterior">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="vs-products-track" id="track3">
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" alt="Mochila deportiva">
                            <span class="vs-product-badge">Popular</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>Mochila Deportiva</h4>
                            <p class="vs-product-type">Gran capacidad, logo bordado</p>
                            <p class="vs-product-price">28,00 €</p>
                            <p class="vs-product-club">+4,20 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" alt="Bolsa de Deporte">
                        </div>
                        <div class="vs-product-info">
                            <h4>Bolsa de Deporte</h4>
                            <p class="vs-product-type">Compartimento para calzado</p>
                            <p class="vs-product-price">20,00 €</p>
                            <p class="vs-product-club">+3,00 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" alt="Medias de juego">
                        </div>
                        <div class="vs-product-info">
                            <h4>Medias de Competición</h4>
                            <p class="vs-product-type">Pack de 2 pares</p>
                            <p class="vs-product-price">12,00 €</p>
                            <p class="vs-product-club">+1,80 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" alt="Gorra del club">
                            <span class="vs-product-badge">Nuevo</span>
                        </div>
                        <div class="vs-product-info">
                            <h4>Gorra del Club</h4>
                            <p class="vs-product-type">Escudo bordado, ajustable</p>
                            <p class="vs-product-price">14,00 €</p>
                            <p class="vs-product-club">+2,10 € para tu club</p>
                        </div>
                    </div>
                    <div class="vs-product-card vs-animate">
                        <div class="vs-product-img-wrap">
                            <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" alt="Botella térmica">
                        </div>
                        <div class="vs-product-info">
                            <h4>Botella Térmica 750ml</h4>
                            <p class="vs-product-type">Acero inoxidable, logo grabado</p>
                            <p class="vs-product-price">16,00 €</p>
                            <p class="vs-product-club">+2,40 € para tu club</p>
                        </div>
                    </div>
                </div>
                <button class="vs-scroll-btn next" data-target="track3" aria-label="Siguiente">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </section>

        <!-- ===== FEATURES BAR ===== -->
        <div class="vs-features">
            <div class="vs-feature-item vs-animate">
                <div class="vs-feature-icon">🎨</div>
                <div class="vs-feature-title">Personalización Total</div>
                <div class="vs-feature-desc">Logo de tu club bordado o sublimado en cada prenda</div>
            </div>
            <div class="vs-feature-item vs-animate">
                <div class="vs-feature-icon">🚚</div>
                <div class="vs-feature-title">Envío Gratis +60€</div>
                <div class="vs-feature-desc">Entrega en 5-7 días laborables en toda España</div>
            </div>
            <div class="vs-feature-item vs-animate">
                <div class="vs-feature-icon">💰</div>
                <div class="vs-feature-title">Tu Club Gana</div>
                <div class="vs-feature-desc">5-10% de cada venta va directamente a tu club</div>
            </div>
            <div class="vs-feature-item vs-animate">
                <div class="vs-feature-icon">🔄</div>
                <div class="vs-feature-title">Devolución 30 Días</div>
                <div class="vs-feature-desc">Cambios y devoluciones sin complicaciones</div>
            </div>
        </div>

        <!-- ===== HOW IT WORKS ===== -->
        <section class="vs-how" id="como-funciona">
            <h2>Cómo Funciona</h2>
            <div class="vs-how-grid">
                <div class="vs-how-step vs-animate">
                    <div class="vs-how-num">1</div>
                    <h3>Tu Club se Registra</h3>
                    <p>El club se da de alta en VaedSaas (100% gratis) y automáticamente se habilita su tienda personalizada con su escudo.</p>
                </div>
                <div class="vs-how-step vs-animate">
                    <div class="vs-how-num">2</div>
                    <h3>Los Jugadores Compran</h3>
                    <p>Jugadores, familias y aficionados compran directamente la ropa personalizada con el escudo del club.</p>
                </div>
                <div class="vs-how-step vs-animate">
                    <div class="vs-how-num">3</div>
                    <h3>El Club Gana</h3>
                    <p>VaedSaas gestiona producción y envío. El club recibe automáticamente entre un 5% y 10% de cada venta. Cero gestión.</p>
                </div>
            </div>
        </section>

        <!-- ===== FULL-WIDTH BANNER 2 ===== -->
        <div class="vs-banner">
            <img src="{{ asset('images/public/personal-trainer-sports-outfit-takes-notes-clipboard-city-park-area-training-exercising-endurance-healthy-lifestyle-concept-outdoor.jpg') }}" alt="Calidad premium">
            <div class="vs-banner-overlay" style="background: linear-gradient(to left, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
            <div class="vs-banner-content" style="left:auto;right:40px;text-align:right;">
                <div class="vs-hero-tag">Calidad Premium</div>
                <h1 style="font-size:clamp(28px,5vw,48px);font-weight:900;text-transform:uppercase;margin:0 0 14px;line-height:1.05;">
                    Materiales que rinden como tú
                </h1>
                <p style="font-size:15px;color:rgba(255,255,255,0.8);margin:0 0 24px;line-height:1.5;margin-left:auto;">
                    Tejidos transpirables, costuras reforzadas y acabados profesionales. Fabricados para soportar entrenamientos intensivos.
                </p>
                <a href="#catalogo" class="vs-hero-btn">Ver Catálogo</a>
            </div>
        </div>

        <!-- ===== CTA ===== -->
        <section class="vs-cta">
            <h2>¿Listo para Equipar a tu Club?</h2>
            <p>Registra tu club en VaedSaas y activa tu tienda personalizada en minutos. Sin costes iniciales, sin gestión, solo ganancias.</p>
            <a href="{{ route('home') }}#contacto" class="vs-cta-btn">Registrar mi Club</a>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer class="vs-footer">
            <div class="vs-footer-inner">
                <div class="vs-footer-brand">
                    <a href="{{ route('home') }}" class="vs-nav-logo" style="margin-bottom:8px;">
                        <img src="{{ asset('images/logos/logo_vaed.png') }}" alt="VAED Sport" style="height:30px;filter:brightness(0) invert(1);">
                        <span style="color:#fff;font-size:18px;">VAED Sport</span>
                    </a>
                    <p>Ropa deportiva personalizada para clubes de fútbol amateur. Tu club gana con cada compra.</p>
                </div>
                <div class="vs-footer-col">
                    <h4>Productos</h4>
                    <a href="#catalogo">Camisetas</a>
                    <a href="#catalogo">Chándales</a>
                    <a href="#catalogo">Accesorios</a>
                    <a href="#colecciones">Colecciones</a>
                </div>
                <div class="vs-footer-col">
                    <h4>Información</h4>
                    <a href="#como-funciona">Cómo Funciona</a>
                    <a href="{{ route('home') }}#por-que-gratis">¿Por qué Gratis?</a>
                    <a href="{{ route('home') }}#contacto">Contacto</a>
                </div>
                <div class="vs-footer-col">
                    <h4>Legal</h4>
                    <a href="{{ route('home') }}">Volver a VaedSaas</a>
                </div>
            </div>
            <div class="vs-footer-bottom">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Vaed-APP') }}. Todos los derechos reservados.</p>
            </div>
        </footer>

        <!-- WhatsApp Float Button -->
        <a href="https://wa.me/34600646123?text=Hola,%20me%20interesa%20la%20ropa%20deportiva%20personalizada%20de%20VAED%20Sport"
           target="_blank"
           rel="noopener noreferrer"
           style="position:fixed;bottom:24px;right:24px;z-index:200;background:#25D366;color:#fff;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(0,0,0,0.3);transition:transform 0.2s;"
           onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"
           aria-label="Contactar por WhatsApp">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>

        <!-- Product Image Lightbox -->
        <div class="vs-lightbox" id="vsLightbox">
            <button class="vs-lightbox-close" id="vsLightboxClose" aria-label="Cerrar">&times;</button>
            <img id="vsLightboxImg" src="" alt="">
        </div>

        <script>
            (function () {
                // Navbar scroll effect
                var nav = document.getElementById('vsNav');
                if (nav) {
                    window.addEventListener('scroll', function () {
                        nav.classList.toggle('scrolled', window.scrollY > 10);
                    });
                }

                // Mobile nav toggle
                var toggle = document.getElementById('navToggle');
                var links = document.getElementById('navLinks');
                if (toggle && links) {
                    toggle.addEventListener('click', function () {
                        links.classList.toggle('open');
                    });
                }

                // Product carousel scroll buttons
                document.querySelectorAll('.vs-scroll-btn').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var target = document.getElementById(btn.getAttribute('data-target'));
                        if (!target) return;
                        var amount = 320;
                        if (btn.classList.contains('prev')) {
                            target.scrollLeft -= amount;
                        } else {
                            target.scrollLeft += amount;
                        }
                    });
                });

                // Scroll animations (IntersectionObserver)
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('vs-animated');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });

                document.querySelectorAll('.vs-animate').forEach(function (el) {
                    observer.observe(el);
                });

                // Product image lightbox
                var lightbox = document.getElementById('vsLightbox');
                var lightboxImg = document.getElementById('vsLightboxImg');
                var lightboxClose = document.getElementById('vsLightboxClose');

                document.querySelectorAll('.vs-product-img-wrap').forEach(function (wrap) {
                    wrap.addEventListener('click', function (e) {
                        var img = wrap.querySelector('img');
                        if (img && lightbox && lightboxImg) {
                            lightboxImg.src = img.src;
                            lightboxImg.alt = img.alt;
                            lightbox.classList.add('open');
                            document.body.style.overflow = 'hidden';
                        }
                    });
                });

                function closeLightbox() {
                    if (lightbox) {
                        lightbox.classList.remove('open');
                        document.body.style.overflow = '';
                    }
                }
                if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
                if (lightbox) lightbox.addEventListener('click', function (e) {
                    if (e.target === lightbox) closeLightbox();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeLightbox();
                });

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(function (a) {
                    a.addEventListener('click', function (e) {
                        var id = a.getAttribute('href');
                        if (id.length > 1) {
                            var target = document.querySelector(id);
                            if (target) {
                                e.preventDefault();
                                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                // Close mobile nav
                                if (links) links.classList.remove('open');
                            }
                        }
                    });
                });
            })();
        </script>
    </body>
</html>
