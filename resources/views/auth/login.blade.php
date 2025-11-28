<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Trevion APP') }} - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .login-card {
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased">
    <div class="gradient-bg min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-md">
            <!-- Logo/Brand -->
            <div class="text-center mb-8 login-card">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl shadow-xl mb-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Bienvenido</h1>
                <p class="text-primary/10 text-sm sm:text-base">Inicia sesión en tu cuenta</p>
            </div>

            <!-- Login Card -->
            <div class="login-card bg-white rounded-2xl shadow-2xl p-6 sm:p-8 lg:p-10">
                <!-- Status Message -->
                @session('status')
                    <div class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
                        <p class="text-sm text-neon-green">{{ $value }}</p>
                    </div>
                @endsession

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-red-700">
                                <p class="font-semibold mb-1">Ups! Algo salió mal.</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Correo electrónico
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="input-field block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 placeholder-gray-400 text-sm sm:text-base"
                                placeholder="tu@email.com"
                            >
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="input-field block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 placeholder-gray-400 text-sm sm:text-base"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer"
                            >
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                Recordarme
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:text-night-blue transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm sm:text-base shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    >
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Iniciar Sesión
                        </span>
                    </button>
                </form>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            ¿No tienes una cuenta? 
                            <a href="{{ route('register') }}" class="font-semibold text-primary hover:text-night-blue transition-colors">
                                Regístrate aquí
                            </a>
                        </p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-primary/10 text-xs sm:text-sm">
                    © {{ date('Y') }} {{ config('app.name', 'Trevion APP') }}. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
