<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin — Folio' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        sans:    ['DM Sans', 'sans-serif'],
                        mono:    ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        admin: {
                            bg:      '#060b18',
                            sidebar: '#0a0f1e',
                            border:  'rgba(255,255,255,0.05)',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a0f1e; }
        ::-webkit-scrollbar-thumb { background: #1e2d52; border-radius: 3px; }

        .admin-card {
            background: rgba(14, 22, 45, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
        }
        .admin-card:hover {
            border-color: rgba(124, 58, 237, 0.2);
        }

        .input-field {
            width: 100%;
            padding: 0.6rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(15,23,42,0.7);
            color: #e2e8f0;
            font-size: 0.875rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
        }
        .input-field::placeholder { color: #475569; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #94a3b8;
            transition: all 0.15s;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.04);
            color: #e2e8f0;
        }
        .nav-item.active {
            background: rgba(124,58,237,0.12);
            color: #a78bfa;
        }
        .nav-item .nav-icon {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 0.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            flex-shrink: 0;
        }
        .nav-item.active .nav-icon {
            background: rgba(124,58,237,0.2);
            color: #a78bfa;
        }
        .nav-item:hover .nav-icon {
            background: rgba(255,255,255,0.05);
        }
    </style>

    @livewireStyles
</head>

<body class="bg-[#060b18] text-slate-300 font-sans antialiased h-full" x-data="{ mobileOpen: false }">

<div class="flex h-screen overflow-hidden">

    {{-- ── Mobile overlay ── --}}
    <div x-show="mobileOpen"
         @click="mobileOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-20 lg:hidden"
         style="display:none"></div>

    {{-- ═══════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════ --}}
    <aside class="fixed lg:static inset-y-0 left-0 z-30 flex flex-col w-64 bg-[#0a0f1e] border-r border-white/5 transition-transform duration-300 lg:translate-x-0"
           :class="mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Brand --}}
        <div class="h-16 flex items-center px-5 border-b border-white/5 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-violet-600 flex items-center justify-center shadow-lg shadow-violet-600/30">
                    <i class="fas fa-shield-alt text-white text-xs"></i>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-display font-bold text-white text-[15px]">Folio</span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-violet-400 mt-0.5">Admin Panel</span>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            @php $path = request()->path(); @endphp

            <p class="px-3 py-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-600">Platform</p>

            <a href="{{ route('admin') }}" class="nav-item {{ $path === 'admin' ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users"></i></span>
                Users
            </a>

            {{-- Spacer for future nav items --}}
        </nav>

        {{-- Admin profile --}}
        <div class="p-4 border-t border-white/5 flex-shrink-0">
            <div class="flex items-center gap-3 mb-3 px-1">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-purple-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow shadow-violet-500/20">
                    {{ strtoupper(mb_substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-200 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-violet-400 font-medium">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-medium text-slate-500 hover:text-red-400 hover:bg-red-500/8 transition-all">
                    <i class="fas fa-sign-out-alt text-[10px]"></i>
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════
         MAIN AREA
    ═══════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top bar --}}
        <header class="h-16 flex items-center justify-between px-5 lg:px-8 border-b border-white/5 bg-[#0a0f1e]/60 backdrop-blur-sm flex-shrink-0">
            {{-- Mobile menu toggle --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <i class="fas fa-bars text-sm"></i>
            </button>

            {{-- Page title slot --}}
            <div class="hidden lg:block">
                <p class="text-xs text-slate-500">
                    <span class="text-slate-400 font-medium">Folio</span>
                    <i class="fas fa-chevron-right text-[9px] mx-1.5 opacity-40"></i>
                    <span>Admin</span>
                </p>
            </div>

            {{-- Right side info --}}
            <div class="flex items-center gap-3 ml-auto">
                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-[11px] font-bold text-violet-400">
                    <i class="fas fa-shield-alt text-[9px]"></i> Admin session
                </span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-purple-700 flex items-center justify-center text-white text-xs font-bold shadow shadow-violet-500/20">
                    {{ strtoupper(mb_substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>

    </div>
</div>

@stack('scripts')
@livewireScripts
</body>
</html>
