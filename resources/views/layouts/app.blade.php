<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blood Fighters') }}</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Toast CSS --}}
    <style>
        .toast-message {
            position: fixed;
            top: 25px;
            right: 25px;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 14px 25px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            z-index: 9999;
            animation: fadeSlide 4s ease forwards;
        }

        @keyframes fadeSlide {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }

            20% {
                opacity: 1;
                transform: translateX(0);
            }

            80% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateX(50px);
            }
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">

        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @isset($header)
            <header class="bg-white shadow border-b-2 border-red-500">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main Content --}}
        <main>
            {{ $slot }}
        </main>

    </div>


    {{-- ✅ Toast Success Message --}}
    @if(session('success'))
        <div class="toast-message">
            {{ session('success') }}
        </div>
    @endif

</body>

</html>
