<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="retro">

<head>
    @include('components.head')
    <style>
        .toast {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .toast-show {
            opacity: 1;
        }

        @keyframes grow-shrink {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .animated-logo {
            height: 200px;
            width: 200px;
            animation: grow-shrink 2s infinite ease-in-out;
        }
    </style>

</head>

<body class="flex flex-col mx-auto bg-base-100 font-sans">
    <main class="{{ $class ?? 'p-4' }}" role="main">
        <div id="splash-screen"
            class="fixed inset-0 flex items-center justify-center bg-gradient-to-br from-base-200 to-base-300 min-h-screen z-[9999] transition-opacity duration-500 ease-in-out opacity-100">
            <div class="relative flex flex-col items-center justify-center p-8 bg-slate-200 rounded-lg shadow-lg">
                <!-- Loading Animation -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Sioner" class="mr-2 animated-logo">
                </div>
                <!-- Logo and Branding -->
                <div class="mt-6 flex flex-col items-center">
                    <h1 class="text-3xl font-bold text-[#eb873b]">SDC DENTAL CLINIC</h1>
                    <p class="text-base-content text-sm mt-2 italic text-black">Tunggu sebentar, sedang memuat...</p>
                </div>
            </div>
        </div>


        {{ $slot }}

        <div id="toast-container" class="fixed z-50 space-y-4 top-5 right-5"></div>


        <script>
            function showToast(message, type) {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');

                toast.classList.add(
                    'relative', 'shadow-lg', 'bg-white', 'p-4', 'rounded-lg', 'flex',
                    'items-center', 'justify-between', 'border-l-4', `border-${type}`,
                    'transition-transform', 'transition-opacity', 'transform', 'duration-300', 'ease-in-out',
                    'opacity-0', 'translate-x-full'
                );

                toast.innerHTML = `
            <div class="flex items-center flex-grow space-x-2">
                <span class="font-semibold">${message}</span>
            </div>
            <button class="ml-4 btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.remove()">✕</button>
        `;

                toastContainer.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-x-full', 'opacity-0');
                    toast.classList.add('translate-x-0', 'opacity-100');
                }, 100);

                setTimeout(() => {
                    toast.classList.remove('translate-x-0', 'opacity-100');
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 15000);
            }

            @if (session('toast'))
                showToast('{{ session('toast.message') }}', '{{ session('toast.type') }}');
            @endif
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var splashScreen = document.getElementById('splash-screen');

                splashScreen.classList.add('show');

                window.addEventListener('load', function() {
                    splashScreen.classList.remove('show');
                });
            });

            window.addEventListener('beforeunload', function() {
                var splashScreen = document.getElementById('splash-screen');
                splashScreen.classList.add('show');
            });
        </script>

    </main>
    @stack('scripts')
</body>

</html>
