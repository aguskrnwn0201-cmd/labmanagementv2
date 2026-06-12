<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Management Lab - Academic Core</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed-variant": "#5a00c6",
                        "on-secondary": "#ffffff",
                        "surface-container": "#edeef0",
                        "on-primary-container": "#d4dcff",
                        "primary-container": "#1a56db",
                        "inverse-on-surface": "#f0f1f3",
                        "on-surface-variant": "#434654",
                        "tertiary": "#005438",
                        "on-surface": "#191c1e",
                        "outline": "#737686",
                        "on-tertiary-container": "#7af3bb",
                        "tertiary-fixed": "#81f9c1",
                        "surface-container-low": "#f3f4f6",
                        "outline-variant": "#c3c5d7",
                        "inverse-primary": "#b5c4ff",
                        "on-tertiary-fixed": "#002113",
                        "surface-dim": "#d9dadc",
                        "on-error-container": "#93000a",
                        "on-tertiary": "#ffffff",
                        "background": "#f8f9fb",
                        "surface": "#f8f9fb",
                        "secondary-container": "#8b4aff",
                        "primary-fixed-dim": "#b5c4ff",
                        "inverse-surface": "#2e3132",
                        "secondary": "#7127e5",
                        "primary": "#003fb1",
                        "primary-fixed": "#dbe1ff",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "surface-container-high": "#e7e8ea",
                        "surface-bright": "#f8f9fb",
                        "on-secondary-fixed": "#25005a",
                        "surface-variant": "#e1e2e4",
                        "secondary-fixed-dim": "#d2bbff",
                        "on-primary-fixed": "#00174d",
                        "on-tertiary-fixed-variant": "#005236",
                        "on-background": "#191c1e",
                        "surface-tint": "#1353d8",
                        "on-secondary-container": "#fffbff",
                        "tertiary-container": "#006f4b",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed": "#eaddff",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#63dca6",
                        "surface-container-highest": "#e1e2e4",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#003dab"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "16px",
                        "base": "4px",
                        "container-max": "1440px",
                        "gutter": "24px",
                        "margin-desktop": "32px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-sm": ["Inter"],
                        "body-sm": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            user-select: none;
        }
        .drawer-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        body {
            min-height: max(884px, 100dvh);
        }
        /* Custom dynamic active state style */
        .nav-active {
            border-left-width: 4px;
            --tw-border-opacity: 1;
            border-color: rgb(0 63 177 / var(--tw-border-opacity));
            background-color: rgb(0 63 177 / 0.1);
            color: rgb(0 63 177 / var(--tw-border-opacity));
            font-weight: 700;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md text-body-md overflow-x-hidden">

    <div class="fixed inset-0 bg-black/50 z-40 opacity-0 pointer-events-none transition-opacity duration-300" id="drawerOverlay" onclick="toggleDrawer()"></div>

    <aside class="fixed left-0 top-0 h-full w-[280px] bg-[#111827] z-50 transform -translate-x-full lg:translate-x-0 drawer-transition flex flex-col shadow-sm border-r border-outline-variant" id="mainDrawer">
        <div class="px-6 py-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">science</span>
            </div>
            <span class="font-headline-md text-headline-md text-white">Management Lab</span>
        </div>

        {{-- CONTAINER NAVIGASI UTAMA --}}
        <nav class="flex-1 overflow-y-auto px-4 space-y-1 py-2">
            
            {{-- ========================================== --}}
            {{-- SEKSI MENU GURU (Jika session role adalah 'guru') --}}
            {{-- ========================================== --}}
            @if(session('role') == 'guru' || request()->is('guru*'))
                <div class="px-4 py-2 text-xs font-bold text-outline uppercase tracking-widest">Menu Guru</div>

                <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('guru.dashboard') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('jadwal.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">event_note</span>
                    <span>Jadwal Lab</span>
                </a>
                <a href="{{ route('booking.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('booking.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">add_task</span>
                    <span>Booking Lab</span>
                </a>
              <div class="mt-4 px-4 py-2 text-xs font-bold text-outline uppercase tracking-widest">Laporan (Public)</div>
                <a href="{{ route('laporan.penggunaan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan.penggunaan') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span>Laporan Penggunaan</span>
                </a>
                <a href="{{ route('laporan.inventaris') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan.inventaris') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">history_edu</span>
                    <span>Laporan Inventaris</span>
                </a>
                <a href="{{ route('laporan-kerusakan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan-kerusakan.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">report_problem</span>
                    <span>Laporan Kerusakan</span>
                </a>

            {{-- ========================================== --}}
            {{-- SEKSI MENU SISWA (Jika session role adalah 'siswa') --}}
            {{-- ========================================== --}}
            @elseif(session('role') == 'siswa' || request()->is('siswa*'))
                <div class="px-4 py-2 text-xs font-bold text-outline uppercase tracking-widest">Menu Siswa</div>

                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('siswa.dashboard') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('jadwal.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">event_note</span>
                    <span>Jadwal Lab</span>
                </a>
                <a href="{{ route('laporan-kerusakan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan-kerusakan.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">report_problem</span>
                    <span>Laporan Kerusakan</span>
                </a>

            {{-- ========================================== --}}
            {{-- SEKSI MENU TEKNISI / ADMIN (Default jika tidak ada session role) --}}
            {{-- ========================================== --}}
            @else
                <div class="px-4 py-2 text-xs font-bold text-outline uppercase tracking-widest">Main Menu (Teknisi)</div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('kalender.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('kalender.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span>Kalender Lab</span>
                </a>
                <a href="{{ route('labs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('labs.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">science</span>
                    <span>Data Lab</span>
                </a>
                <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('jadwal.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">event_note</span>
                    <span>Jadwal</span>
                </a>
                <a href="{{ route('booking.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('booking.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">add_task</span>
                    <span>Booking</span>
                </a>
                <a href="{{ route('inventaris.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('inventaris.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span>Inventaris</span>
                </a>

                <div class="mt-4 px-4 py-2 text-xs font-bold text-outline uppercase tracking-widest">Reporting</div>
                <a href="{{ route('laporan.penggunaan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan.penggunaan') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span>Penggunaan Lab</span>
                </a>
                <a href="{{ route('laporan.inventaris') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan.inventaris') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">history_edu</span>
                    <span>Laporan Inventaris</span>
                </a>
                <a href="{{ route('laporan-kerusakan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('laporan-kerusakan.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">report_problem</span>
                    <span>Laporan Kerusakan</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-bold text-outline uppercase tracking-wider">Admin Tools</div>
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-surface-container-high/10 transition-all {{ request()->routeIs('users.index') ? 'nav-active' : '' }}">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span>Manajemen User</span>
                </a>
            @endif
        </nav>
       {{-- TOMBOL KELUAR / LOGOUT (Muncul untuk semua Role) --}}
        <div class="p-4 border-t border-outline-variant/20">
            <form action="{{ route('role.logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 text-error bg-error/10 rounded-xl font-bold hover:bg-error hover:text-white transition-all duration-200 active:scale-95">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Kembali / Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="min-h-screen flex flex-col lg:pl-[280px]">
        <header class="sticky top-0 z-30 bg-surface dark:bg-surface-dim border-b border-outline-variant h-16 flex items-center justify-between px-margin-mobile md:px-margin-desktop transition-all duration-200">
            <div class="flex items-center gap-4">
                <button class="p-2 rounded-full hover:bg-surface-container-low transition-all duration-200 active:scale-90 text-primary lg:hidden" onclick="toggleDrawer()">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="font-headline-md text-headline-md text-primary hidden sm:block">Sistem Manajemen Laboratorium</h1>
                <h1 class="font-headline-sm text-headline-sm text-primary sm:hidden">MLab</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <button class="p-2 rounded-full hover:bg-surface-container-low text-on-surface-variant">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="w-10 h-10 rounded-full border-2 border-primary-container overflow-hidden cursor-pointer hover:ring-4 hover:ring-primary/10 transition-all">
                    <img alt="User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjU5dBJJfkgIJLZRvr01SgS5rrIFLmqb__Zi8cbxEmqaiFR-Ly_eeNFPu8E4ZUeYB18KVpJxEOvK1UMGsMhya12ifuFsXLdExIozBCh7sDqfCOMT72Rhx3XPLrfKt3hrXqPKeXFw3QN7Yr1Y_z9pH05PqdI5AgKzGmS23Ese9ig3Ap3v_uMOr18NacuSET425b18J5_3gGmNeY878lqTuAHLRA0lstPE_VVSeh2i-wK7ZFgJ-y2hpiXrKb3_f4HYF__mHVbC6Nvp5H"/>
                </div>
            </div>
        </header>

        <main class="flex-1 p-margin-mobile md:p-margin-desktop space-y-6 max-w-7xl mx-auto w-full">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('mainDrawer');
            const overlay = document.getElementById('drawerOverlay');
            
            if (drawer.classList.contains('-translate-x-full')) {
                drawer.classList.remove('-translate-x-full');
                overlay.classList.remove('pointer-events-none', 'opacity-0');
                overlay.classList.add('opacity-100');
                document.body.classList.add('overflow-hidden');
            } else {
                drawer.classList.add('-translate-x-full');
                overlay.classList.add('pointer-events-none', 'opacity-0');
                overlay.classList.remove('opacity-100');
                document.body.classList.remove('overflow-hidden');
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const drawer = document.getElementById('mainDrawer');
                if (!drawer.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
                    toggleDrawer();
                }
            }
        });
    </script>
</body>
</html>