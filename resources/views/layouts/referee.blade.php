<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
        <meta name="theme-color" content="#005DFF">

        <title>{{ $title ?? 'Árbitro' }} - {{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <style>
            * {
                font-family: 'Inter', sans-serif;
            }
            
            [x-cloak] {
                display: none !important;
            }
            
            html, body {
                height: 100%;
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch;
            }
            
            body {
                background: linear-gradient(135deg, #005DFF 0%, #001C40 100%);
                position: relative;
            }
            
            /* Mobile-first optimizations */
            .mobile-container {
                max-width: 480px;
                margin: 0 auto;
                min-height: 100vh;
                background: #f8f9fa;
                position: relative;
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
            }
            
            .safe-area-top {
                padding-top: env(safe-area-inset-top, 0);
            }
            
            .safe-area-bottom {
                padding-bottom: env(safe-area-inset-bottom, 0);
            }
            
            /* Card animations */
            .card-tap {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                transform-origin: center;
            }
            
            .card-tap:active {
                transform: scale(0.98);
            }
            
            /* Bottom navigation safe area */
            .bottom-nav {
                padding-bottom: max(env(safe-area-inset-bottom), 1rem);
            }
            
            /* Pull to refresh indicator */
            .pull-refresh {
                transform: translateY(-100%);
                transition: transform 0.3s ease;
            }
            
            /* Smooth scrolling */
            .scroll-smooth {
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
            }
            
            /* Haptic feedback simulation */
            @keyframes haptic {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-2px); }
                75% { transform: translateX(2px); }
            }
            
            .haptic-feedback:active {
                animation: haptic 0.1s ease;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="mobile-container">
            <!-- Header -->
            <div class="safe-area-top sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if(isset($backUrl))
                                <a href="{{ $backUrl }}" wire:navigate class="p-2 -ml-2 rounded-xl hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </a>
                            @endif
                            <div>
                                <h1 class="text-lg font-bold text-gray-900">{{ $title ?? 'Árbitro' }}</h1>
                                @if(isset($subtitle))
                                    <p class="text-xs text-gray-500">{{ $subtitle }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(isset($headerActions))
                                {{ $headerActions }}
                            @else
                                <!-- User Avatar -->
                                <button @click="showMenu = !showMenu" class="relative p-1 rounded-full hover:bg-gray-100 transition-colors">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                             class="w-8 h-8 rounded-full object-cover border-2 border-primary" 
                                             alt="{{ auth()->user()->name }}">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                                            <span class="text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="scroll-smooth" style="min-height: calc(100vh - 120px);">
                {{ $slot }}
            </main>

            <!-- Bottom Navigation (optional) -->
            @if(isset($bottomNav) && $bottomNav)
                <div class="bottom-nav fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-40">
                    <div class="mobile-container mx-auto">
                        <nav class="flex items-center justify-around px-2 py-2">
                            <a href="{{ route('referee.dashboard') }}" wire:navigate
                               class="flex flex-col items-center gap-1 px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('referee.dashboard') ? 'text-primary bg-primary/10' : 'text-gray-500 hover:text-gray-700' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="text-xs font-semibold">Inicio</span>
                            </a>
                            
                            <a href="{{ route('referee.profile') }}" wire:navigate
                               class="flex flex-col items-center gap-1 px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('referee.profile') ? 'text-primary bg-primary/10' : 'text-gray-500 hover:text-gray-700' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-xs font-semibold">Perfil</span>
                            </a>
                        </nav>
                    </div>
                </div>
            @endif
        </div>

        <!-- Dropdown Menu -->
        <div x-data="{ showMenu: false }" @click.away="showMenu = false">
            <div x-show="showMenu" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4"
                 @click="showMenu = false">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xs overflow-hidden" @click.stop>
                    <div class="p-4 bg-gradient-to-br from-primary to-blue-600">
                        <div class="flex items-center gap-3">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-white" 
                                     alt="{{ auth()->user()->name }}">
                            @else
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                    <span class="text-lg font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-white/80 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('referee.profile') }}" wire:navigate
                           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-semibold text-gray-700">Mi Perfil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 transition-colors text-left">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="font-semibold text-red-500">Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
