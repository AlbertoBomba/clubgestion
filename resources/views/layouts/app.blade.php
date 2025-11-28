<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Trevion APP') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <style>
            * {
                font-family: 'Inter', sans-serif;
            }
            
            .gradient-bg {
                background: linear-gradient(135deg, #005DFF 0%, #001C40 100%);
            }
            
            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }
            
            .card-modern {
                transition: all 0.3s ease;
            }
            
            .card-modern:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0, 93, 255, 0.15);
            }
            
            .sidebar-link {
                transition: all 0.2s ease;
            }
            
            .sidebar-link:hover {
                background: linear-gradient(135deg, #005DFF 0%, #001C40 100%);
                color: white;
                transform: translateX(4px);
            }
            
            .sidebar-link.active {
                background: linear-gradient(135deg, #005DFF 0%, #001C40 100%);
                color: white;
            }
        </style>
    </head>
    <body class="antialiased">
        <x-banner />

        <!-- Impersonation Banner -->
        @if(session()->has('impersonator_id'))
            <div class="bg-gradient-to-r from-neon-green to-primary shadow-lg sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div class="text-white">
                                <p class="font-bold text-sm">Modo Suplantación Activo</p>
                                <p class="text-xs text-neon-green/10">Estás operando como: <span class="font-semibold">{{ auth()->user()->name }}</span> ({{ auth()->user()->email }})</p>
                            </div>
                        </div>
                        <form action="{{ route('leave-impersonation') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white text-neon-green rounded-lg font-semibold hover:bg-neon-green/5 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Volver a cuenta Master
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white-pure to-gray-100 ">
            @livewire('navigation-menu')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="glass-effect shadow-lg border-b border-primary/10">
                    <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
            <main class="py-8 ">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
