<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Folio — Build Your Portfolio' }}</title>

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
                        brand: {
                            dark:    '#0a0f1e',
                            light:   '#f5f4f0',
                            accent:  '#2563eb',
                            accent2: '#7c3aed',
                        }
                    },
                    animation: {
                        'blob':       'blob 9s infinite',
                        'spin-slow':  'spin 14s linear infinite',
                        'float':      'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%':   { transform: 'translate(0px, 0px) scale(1)' },
                            '33%':  { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%':  { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%':      { transform: 'translateY(-12px)' },
                        }
                    },
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f5f4f0; }
        html.dark ::-webkit-scrollbar-track { background: #0a0f1e; }
        ::-webkit-scrollbar-thumb { background: #c8c5bc; border-radius: 3px; }
        html.dark ::-webkit-scrollbar-thumb { background: #2a3352; }

        .glass {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(0,0,0,0.07);
        }
        html.dark .glass {
            background: rgba(14,22,45,0.80);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .glass-card {
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        html.dark .glass-card {
            background: rgba(18,28,55,0.55);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .glass-card:hover {
            border-color: rgba(37,99,235,0.35);
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(37,99,235,0.07);
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(135deg, #2563eb 0%, #7c3aed 50%, #db2777 100%);
        }
        h1, h2, h3 { font-family: 'Syne', sans-serif; }

        .bg-grid {
            background-image:
                linear-gradient(to right, rgba(37,99,235,0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(37,99,235,0.04) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
        }

        .input-field {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.8);
            color: #1e293b;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        html.dark .input-field {
            background: rgba(15,23,42,0.7);
            border-color: rgba(255,255,255,0.08);
            color: #e2e8f0;
        }
        .input-field:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }

        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 1;
            pointer-events: none;
            opacity: 0.018;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }
    </style>

    <script>
        (function () {
            const t = localStorage.getItem('theme');
            if (t === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>

    @livewireStyles
</head>

<body class="bg-brand-light dark:bg-brand-dark text-slate-600 dark:text-slate-300 font-sans antialiased overflow-x-hidden selection:bg-brand-accent/20 selection:text-brand-accent transition-colors duration-300 relative">

    <div class="fixed inset-0 pointer-events-none z-0 bg-grid"></div>

    {{-- SaaS Navigation --}}
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" id="saas-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-4">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg bg-brand-accent flex items-center justify-center shadow-lg shadow-brand-accent/30">
                        <i class="fas fa-bolt text-white text-sm"></i>
                    </div>
                    <span class="font-display font-bold text-slate-900 dark:text-white text-lg group-hover:text-brand-accent transition-colors">
                        Folio
                    </span>
                </a>

                {{-- Center links (guest only) --}}
                @guest
                <div class="hidden md:flex items-center gap-7">
                    <a href="{{ url('/') }}#features" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Features</a>
                    <a href="{{ url('/') }}#how-it-works" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">How it works</a>
                </div>
                @endguest

                @auth
                <div class="hidden md:flex items-center gap-1">
                    @php $cur = request()->path(); @endphp
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ $cur === 'dashboard' ? 'text-brand-accent bg-brand-accent/8' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <i class="fas fa-th-large text-xs opacity-70"></i> Dashboard
                    </a>
                    <a href="{{ route('analytics') }}"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ $cur === 'analytics' ? 'text-brand-accent bg-brand-accent/8' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <i class="fas fa-chart-line text-xs opacity-70"></i> Analytics
                    </a>
                    <a href="{{ url('/u/' . auth()->user()->username) }}" target="_blank"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-brand-accent hover:bg-brand-accent/8 transition-colors">
                        <i class="fas fa-external-link-alt text-xs"></i> My Portfolio
                    </a>
                </div>
                @endauth

                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    <button onclick="toggleTheme()" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors" aria-label="Toggle Theme">
                        <i class="fas fa-sun hidden dark:block text-yellow-400 text-sm"></i>
                        <i class="fas fa-moon block dark:hidden text-slate-500 text-sm"></i>
                    </button>

                    @guest
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-85 transition-all shadow-md">
                            Get Started
                        </a>
                    </div>
                    @endguest

                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-full glass hover:border-brand-accent/40 transition-all">
                            <div class="w-7 h-7 rounded-full bg-brand-accent flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200 hidden sm:block">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-48 glass rounded-xl shadow-xl overflow-hidden z-50" style="display:none;">
                            <div class="px-4 py-3 border-b border-slate-200 dark:border-white/10">
                                <p class="text-xs text-slate-500 dark:text-slate-400">Signed in as</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">
                                <i class="fas fa-th-large w-4 text-xs opacity-60"></i> Dashboard
                            </a>
                            <a href="{{ route('analytics') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">
                                <i class="fas fa-chart-line w-4 text-xs opacity-60"></i> Analytics
                            </a>
                            <a href="{{ url('/u/' . auth()->user()->username) }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">
                                <i class="fas fa-external-link-alt w-4 text-xs opacity-60"></i> View Portfolio
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors border-t border-slate-200 dark:border-white/10">
                                    <i class="fas fa-sign-out-alt w-4 text-xs opacity-80"></i> Log out
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth

                    {{-- Mobile menu button --}}
                    <button onclick="document.getElementById('mobile-saas-menu').classList.toggle('hidden')" class="flex md:hidden p-2 rounded-lg text-slate-600 dark:text-slate-300">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div class="hidden md:hidden absolute top-full left-0 w-full glass border-b border-slate-200 dark:border-white/5" id="mobile-saas-menu">
            <div class="px-4 py-4 space-y-1">
                @guest
                <a href="{{ url('/') }}#features" class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Features</a>
                <a href="{{ url('/') }}#how-it-works" class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">How it works</a>
                <div class="pt-2 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-center rounded-lg border border-slate-200 dark:border-white/10 text-sm font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-center rounded-lg bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold">Get Started</a>
                </div>
                @endguest

                @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Dashboard</a>
                <a href="{{ route('analytics') }}" class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Analytics</a>
                <a href="{{ url('/u/' . auth()->user()->username) }}" class="block px-3 py-2.5 rounded-lg text-sm text-brand-accent">My Portfolio</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2.5 rounded-lg text-sm text-red-500">Log out</button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="relative z-10 pt-[72px]">
        {{ $slot }}
    </main>

    <script>
        function toggleTheme() {
            const h = document.documentElement;
            const isDark = h.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        window.addEventListener('scroll', () => {
            const nav = document.getElementById('saas-navbar');
            if (!nav) return;
            const scrolled = window.scrollY > 20;
            nav.classList.toggle('bg-white/85', scrolled);
            nav.classList.toggle('dark:bg-slate-900/85', scrolled);
            nav.classList.toggle('backdrop-blur-md', scrolled);
            nav.classList.toggle('border-b', scrolled);
            nav.classList.toggle('border-slate-200', scrolled);
            nav.classList.toggle('dark:border-white/5', scrolled);
            nav.classList.toggle('shadow-sm', scrolled);
        });
    </script>

    @stack('scripts')
    @livewireScripts
</body>
</html>
