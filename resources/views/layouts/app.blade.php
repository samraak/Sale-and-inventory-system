<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            
            <div class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0 z-20">
                <div class="p-6 text-2xl font-bold border-b border-gray-800 tracking-wider">IMS Panel</div>
                <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                    
                    <a href="{{ route('dashboard') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('units.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('units.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Units
                    </a>

                    <a href="{{ route('suppliers.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('suppliers.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Suppliers
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Products
                    </a>

                    <a href="{{ route('purchases.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('purchases.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Purchases
                    </a>

                    <a href="{{ route('customers.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Customers
                    </a>

                    <a href="{{ route('sales.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('sales.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Sales
                    </a>

                </nav>
            </div>

            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <header class="bg-white shadow-sm z-10 flex justify-between items-center p-4 border-b border-gray-200">
                    <div class="text-lg font-semibold text-gray-800">
                        {{ $header ?? 'Inventory System' }}
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-md">{{ Auth::user()->name }}</span>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700 hover:underline focus:outline-none">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-gray-50">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>