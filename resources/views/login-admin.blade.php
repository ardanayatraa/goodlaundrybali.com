<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Laundry | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        eco: {
                            100: '#E8F5E9',
                            200: '#C8E6C9',
                            300: '#A5D6A7',
                            400: '#81C784',
                            500: '#66BB6A',
                            600: '#4CAF50',
                            700: '#43A047',
                            800: '#388E3C',
                            900: '#2E7D32',
                        },
                    },
                    fontFamily: {
                        'sans': ['Quicksand', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-eco-100 to-eco-200 font-sans flex items-center justify-center p-4">
    <div class="w-full max-w-md relative">
        <!-- Decorative Elements -->
        <div class="absolute -top-16 -left-16 w-32 h-32 bg-eco-300 rounded-full opacity-30 blur-xl"></div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-eco-400 rounded-full opacity-30 blur-xl"></div>

        <!-- Card Container -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-8 space-y-8 relative overflow-hidden">
            <!-- Logo & Header -->
            <div class="text-center space-y-2">
                <div class="flex justify-center mb-4">
                    <div class="relative w-20 h-20 md:w-24 md:h-24 float">
                        <img src="/assets/img/logo.png" class="h-32 w-auto object-contain mx-auto"
                            alt="GoodLaundry Logo" />
                    </div>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-eco-800">Good Laundry Kedonganan</h1>
                <p class="text-eco-600 font-medium">Welcome Back, Admin!</p>
            </div>


            {{-- Flash generic login error --}}
            @if (session('error'))
                <div class="text-red-600 text-center mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div class="space-y-2">
                    <label for="username" class="text-sm font-medium text-eco-800 block">Username</label>
                    <div class="relative">
                        <input type="text" id="username" name="username"
                            class="w-full px-4 py-3 rounded-lg border-2 border-eco-200 focus:ring-2 focus:ring-eco-500 focus:border-transparent transition duration-200 pl-10"
                            placeholder="Enter your username" value="{{ old('username') }}" required autofocus>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-eco-500 absolute left-3 top-3.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-eco-800 block">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 rounded-lg border-2 border-eco-200 focus:ring-2 focus:ring-eco-500 focus:border-transparent transition duration-200 pl-10"
                            placeholder="Enter your password" required>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-eco-500 absolute left-3 top-3.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-eco-500 to-eco-600 text-white font-medium rounded-lg hover:from-eco-600 hover:to-eco-700 focus:outline-none focus:ring-2 focus:ring-eco-500 focus:ring-offset-2 transform transition duration-200 hover:-translate-y-0.5 shadow-lg shadow-eco-500/30">
                    Sign In
                </button>
            </form>

            <!-- Decorative bottom border -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-eco-300 via-eco-500 to-eco-700">
            </div>
        </div>
    </div>
</body>

</html>
