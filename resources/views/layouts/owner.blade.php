<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - SIM UB GYM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-slate-800">
                UB GYM <span class="text-yellow-500">OWNER</span>
            </div>
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="{{ route('owner.dashboard') }}" class="block p-3 rounded hover:bg-slate-800 {{ request()->routeIs('owner.dashboard') ? 'bg-slate-800' : '' }}">
                    <i class="fa fa-home mr-2"></i> Dashboard
                </a>
                <a href="{{ route('owner.admins') }}" class="block p-3 rounded hover:bg-slate-800 {{ request()->routeIs('owner.admins') ? 'bg-slate-800' : '' }}">
                    <i class="fa fa-users-cog mr-2"></i> Kelola Admin
                </a>
                <a href="{{ route('owner.pt-packages') }}" class="block p-3 rounded hover:bg-slate-800 {{ request()->routeIs('owner.pt-packages') ? 'bg-slate-800' : '' }}">
                    <i class="fa fa-dumbbell mr-2"></i> Paket PT
                </a>
                <a href="{{ route('owner.settings') }}" class="block p-3 rounded hover:bg-slate-800 {{ request()->routeIs('owner.settings') ? 'bg-slate-800' : '' }}">
                    <i class="fa fa-cogs mr-2"></i> Pengaturan Harga
                </a>
                <a href="{{ route('owner.reports') }}" class="block p-3 rounded hover:bg-slate-800 {{ request()->routeIs('owner.reports') ? 'bg-slate-800' : '' }}">
                    <i class="fa fa-file-invoice-dollar mr-2"></i> Laporan
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left p-2 text-red-400 hover:text-red-300">
                        <i class="fa fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                <div class="text-sm text-gray-600">Halo, {{ Auth::user()->name }}</div>
            </header>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>