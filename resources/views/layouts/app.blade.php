<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'CitrusCore ERP')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;700&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-citrus-bg text-slate-900 font-inter min-h-screen">
    <div class="flex min-h-screen">
        <aside class="hidden md:flex w-72 shrink-0 border-r border-slate-200 bg-white/95 backdrop-blur-sm p-5 flex-col">
            <div class="mb-6">
                <h1 class="text-2xl font-ibm font-bold text-citrus-primary">CitrusCore</h1>
                <p class="text-sm text-slate-500">Enterprise Supply Chain</p>
            </div>

            <a href="{{ route('batch.baru') }}"
                class="mb-4 inline-flex items-center justify-center gap-2 rounded-lg bg-citrus-primary text-white px-4 py-2.5 text-sm font-semibold hover:opacity-95 transition">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Batch Baru
            </a>

            <nav class="space-y-1.5 text-sm">
                <a href="{{ route('dashboard.admin') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span><span>Dashboard Admin</span>
                </a>
                <a href="{{ route('dashboard.pedagang') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard.pedagang') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">storefront</span><span>Portal Pedagang</span>
                </a>
                <a href="{{ route('dashboard.logistik') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard.logistik') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">local_shipping</span><span>Logistik</span>
                </a>
            </nav>

            <p class="mt-5 mb-1.5 px-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Modul Enterprise</p>
            <nav class="space-y-1.5 text-sm">
                <a href="{{ route('modules.marketplace.index') }}"
                    class="sidebar-link {{ request()->routeIs('modules.marketplace.index') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">sell</span><span>Marketplace</span>
                </a>
                <a href="{{ route('modules.kontrak.index') }}"
                    class="sidebar-link {{ request()->routeIs('modules.kontrak.index') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">description</span><span>Manajemen Kontrak</span>
                </a>
                <a href="{{ route('modules.demand.index') }}"
                    class="sidebar-link {{ request()->routeIs('modules.demand.index') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">query_stats</span><span>Demand Intelligence</span>
                </a>
                <a href="{{ route('modules.agro.index') }}"
                    class="sidebar-link {{ request()->routeIs('modules.agro.index') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">eco</span><span>Farm & Agro-Sensing</span>
                </a>
                <a href="{{ route('modules.komunikasi.index') }}"
                    class="sidebar-link {{ request()->routeIs('modules.komunikasi.index') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">campaign</span><span>Communication Hub</span>
                </a>
            </nav>

            <div class="mt-auto pt-4 border-t border-slate-200 space-y-1.5 text-sm">
                <a href="{{ route('pengaturan') }}"
                    class="sidebar-link {{ request()->routeIs('pengaturan*') ? 'active' : '' }}"><span
                        class="material-symbols-outlined">settings</span><span>Pengaturan</span></a>
                <a href="{{ route('bantuan') }}"
                    class="sidebar-link {{ request()->routeIs('bantuan') ? 'active' : '' }}"><span
                        class="material-symbols-outlined">support_agent</span><span>Bantuan</span></a>
            </div>
        </aside>

        <main class="flex-1 min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-sm">
                <div class="px-4 md:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="md:hidden text-citrus-primary text-xl font-bold font-ibm">CitrusCore</span>
                        <h2 class="hidden md:block text-lg font-semibold text-slate-800">@yield('header', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('notifikasi') }}" class="icon-btn"><span
                                class="material-symbols-outlined">notifications</span></a>
                        <a href="{{ route('profil') }}" class="icon-btn"><span
                                class="material-symbols-outlined">account_circle</span></a>
                    </div>
                </div>
            </header>

            <section class="p-4 md:p-8">
                @yield('content')
            </section>
        </main>
    </div>
</body>

</html>
