<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $portfolio->hero_name }} — {{ $portfolio->hero_title }}. {{ $portfolio->hero_bio }}">
    <title>{{ $portfolio->hero_name }} | {{ $portfolio->hero_title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
                        'blob':      'blob 9s infinite',
                        'cursor':    'cursor .75s step-end infinite',
                        'spin-slow': 'spin 14s linear infinite',
                        'float':     'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%':   { transform: 'translate(0px, 0px) scale(1)' },
                            '33%':  { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%':  { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        cursor: {
                            '0%, 100%': { opacity: '1' },
                            '50%':      { opacity: '0' },
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
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0,0,0,0.10);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        html.dark .glass-card {
            background: rgba(18,28,55,0.70);
            border: 1px solid rgba(255,255,255,0.09);
            box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        }
        .glass-card:hover {
            border-color: rgba(37,99,235,0.4);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(37,99,235,0.10), 0 4px 12px rgba(0,0,0,0.08);
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
        .chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600;
            letter-spacing: 0.02em;
        }
        .project-img-card .reveal {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease;
        }
        .project-img-card:hover .reveal {
            max-height: 80px;
        }
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 1;
            pointer-events: none; opacity: 0.018;
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

{{-- ======================================================
     NAVIGATION
====================================================== --}}
<nav class="fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <a href="#" class="font-mono text-xl font-bold text-slate-900 dark:text-white hover:text-brand-accent transition-colors">
                &lt;{{ $user->username }}/<span class="text-brand-accent">_</span>&gt;
            </a>

            <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center space-x-8">
                @if(!empty($portfolio->tech_stack))
                <a href="#about" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Stack</a>
                @endif
                @if(!empty($portfolio->projects))
                <a href="#projects" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Work</a>
                @endif
                @if(!empty($portfolio->experience))
                <a href="#experience" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Timeline</a>
                @endif
                <a href="#contact" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Contact</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <button onclick="toggleTheme()" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors">
                    <i class="fas fa-sun hidden dark:block text-yellow-400 text-sm"></i>
                    <i class="fas fa-moon block dark:hidden text-slate-500 text-sm"></i>
                </button>
                @if($portfolio->hero_github)
                <a href="{{ $portfolio->hero_github }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors text-slate-500 dark:text-slate-400">
                    <i class="fab fa-github text-lg"></i>
                </a>
                @endif
                @if($portfolio->contact_email)
                <div class="h-5 w-px bg-slate-300 dark:bg-white/10 mx-1"></div>
                <a href="mailto:{{ $portfolio->contact_email }}" class="px-5 py-2 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-80 transition-all shadow-md">
                    Hire Me
                </a>
                @endif
            </div>

            <div class="flex md:hidden items-center gap-3">
                <button onclick="toggleTheme()" class="p-2 rounded-lg text-slate-900 dark:text-white">
                    <i class="fas fa-sun hidden dark:block text-sm"></i>
                    <i class="fas fa-moon block dark:hidden text-sm"></i>
                </button>
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 rounded-md text-slate-600 dark:text-gray-400">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="hidden md:hidden absolute top-20 left-0 w-full bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-white/5" id="mobile-menu">
        <div class="px-4 pt-2 pb-6 space-y-1">
            @if(!empty($portfolio->tech_stack))
            <a href="#about" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Stack</a>
            @endif
            @if(!empty($portfolio->projects))
            <a href="#projects" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Work</a>
            @endif
            @if(!empty($portfolio->experience))
            <a href="#experience" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Timeline</a>
            @endif
            <a href="#contact" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Contact</a>
            @if($portfolio->contact_email)
            <a href="mailto:{{ $portfolio->contact_email }}" class="block px-3 py-3 rounded-lg text-base font-bold text-brand-accent">Hire Me</a>
            @endif
        </div>
    </div>
</nav>

<main class="relative z-10">

    {{-- ======================================================
         HERO
    ====================================================== --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">

        {{-- Blob decorations --}}
        <div class="absolute top-10 -left-20 w-[500px] h-[500px] bg-blue-500 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.08] dark:opacity-[0.12] animate-blob pointer-events-none"></div>
        <div class="absolute top-20 -right-20 w-[400px] h-[400px] bg-violet-500 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.07] dark:opacity-[0.10] animate-blob pointer-events-none" style="animation-delay:2.5s"></div>
        <div class="absolute -bottom-10 left-1/3 w-[350px] h-[350px] bg-cyan-400 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.06] dark:opacity-[0.08] animate-blob pointer-events-none" style="animation-delay:5s"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-14 items-center w-full">

            {{-- LEFT: Bio --}}
            <div data-aos="fade-right" data-aos-duration="900">

                @php
                $avatarUrl = $portfolio->hero_avatar
                    ? (str_starts_with($portfolio->hero_avatar, 'http')
                        ? $portfolio->hero_avatar
                        : asset('storage/' . $portfolio->hero_avatar))
                    : null;
                @endphp

                {{-- Availability badge --}}
                <div class="inline-flex items-center gap-3 mb-8 px-2 py-2 pr-5 rounded-full bg-white/70 dark:bg-white/5 border border-slate-200 dark:border-white/10 shadow-sm">
                    @if($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="{{ $portfolio->hero_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-white/20">
                    @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white font-bold text-base">
                        {{ strtoupper(substr($portfolio->hero_name, 0, 1)) }}
                    </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-900 dark:text-white leading-none">{{ $portfolio->hero_name }}</span>
                        @if($portfolio->hero_available)
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="flex h-1.5 w-1.5 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                            </span>
                            <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Available for work</span>
                        </div>
                        @endif
                    </div>
                </div>

                <h1 class="text-5xl md:text-[62px] font-display font-bold text-slate-900 dark:text-white tracking-tight mb-6 leading-[1.08]">
                    {{ $portfolio->hero_name }}<br>
                    <span class="text-gradient">{{ $portfolio->hero_title }}</span>
                </h1>

                @if($portfolio->hero_bio)
                <p class="text-[17px] text-slate-500 dark:text-slate-400 mb-8 max-w-md leading-relaxed">
                    {{ $portfolio->hero_bio }}
                </p>
                @endif

                {{-- Rating widget --}}
                <div class="mb-8">
                    <livewire:rating :portfolio-id="$portfolio->id" />
                </div>

                <div class="flex flex-wrap gap-3 mb-8">
                    @if(!empty($portfolio->projects))
                    <a href="#projects" class="px-7 py-3.5 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-brand-dark text-sm font-bold hover:opacity-85 transition-all shadow-md flex items-center gap-2">
                        See my work <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                    @endif
                    @if($portfolio->contact_email)
                    <a href="mailto:{{ $portfolio->contact_email }}" class="px-7 py-3.5 rounded-lg border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white text-sm font-medium hover:bg-slate-100 dark:hover:bg-white/5 transition-all">
                        Get in touch
                    </a>
                    @endif
                </div>

                @if($portfolio->hero_github || $portfolio->hero_linkedin)
                <div class="flex items-center gap-5">
                    @if($portfolio->hero_github)
                    <a href="{{ $portfolio->hero_github }}" target="_blank" class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors text-sm">
                        <i class="fab fa-github text-lg"></i> GitHub
                    </a>
                    @endif
                    @if($portfolio->hero_linkedin)
                    <a href="{{ $portfolio->hero_linkedin }}" target="_blank" class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-brand-accent transition-colors text-sm">
                        <i class="fab fa-linkedin text-lg"></i> LinkedIn
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- RIGHT: Terminal --}}
            <div data-aos="fade-left" data-aos-duration="900" class="hidden md:block relative group">
                @php
                $isCategorized = !empty($portfolio->tech_stack) && isset($portfolio->tech_stack[0]['name']);
                @endphp

                {{-- Glow halo --}}
                <div class="absolute -inset-2 bg-gradient-to-br from-blue-400 via-violet-400 to-indigo-500 rounded-3xl blur-xl opacity-10 dark:opacity-10 group-hover:opacity-18 dark:group-hover:opacity-15 transition-all duration-700 pointer-events-none"></div>
                {{-- Second softer halo for depth --}}
                <div class="absolute -inset-4 bg-gradient-to-br from-blue-300/20 to-violet-300/20 dark:from-blue-600/5 dark:to-violet-600/5 rounded-3xl blur-2xl pointer-events-none"></div>

                <div class="relative font-mono text-sm bg-[#fcfcfc] dark:bg-[#080d16] rounded-2xl overflow-hidden border border-white dark:border-white/10"
                     style="box-shadow: 0 0 0 1px rgba(100,116,139,0.25), 0 2px 4px 0 rgba(0,0,0,0.10), 0 8px 16px -2px rgba(0,0,0,0.14), 0 24px 48px -6px rgba(0,0,0,0.18), 0 40px 80px -12px rgba(99,102,241,0.20);">
                    {{-- Terminal chrome --}}
                    <div class="flex items-center gap-3 px-4 py-3 border-b border-slate-200/80 dark:border-white/5"
                         style="background: linear-gradient(to bottom, #f1f5f9, #e8edf2);">
                        <div class="flex gap-1.5 flex-shrink-0">
                            <span class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-400 shadow-sm"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></span>
                        </div>
                        <div class="flex-1 text-center text-[11px] text-slate-400 dark:text-slate-500 font-mono">~/portfolio — bash</div>
                    </div>
                    {{-- Subtle top inner highlight --}}
                    <div class="h-px bg-gradient-to-r from-transparent via-white/80 to-transparent dark:via-white/5"></div>
                    {{-- Terminal body --}}
                    <div class="p-6 space-y-3 text-slate-600 dark:text-slate-300 leading-relaxed text-[13px] relative"
                         style="box-shadow: inset 0 2px 8px rgba(99,102,241,0.05);">

                        {{-- Faint watermark --}}
                        <div class="absolute bottom-4 right-4 opacity-[0.04] dark:opacity-[0.04] select-none pointer-events-none">
                            <i class="fas fa-terminal text-7xl text-slate-900 dark:text-white"></i>
                        </div>

                        <div>
                            <span class="text-emerald-600 dark:text-emerald-400">➜  ~ </span><span class="text-slate-900 dark:text-white">whoami</span>
                        </div>
                        <div class="pl-4 text-slate-600 dark:text-slate-400">
                            <span class="text-brand-accent font-bold">{{ $portfolio->hero_name }}</span>
                            <span class="text-slate-400 dark:text-slate-600 mx-1">—</span>
                            <span>{{ $portfolio->hero_title }}</span>
                            @if($portfolio->hero_available)
                            <span class="ml-2 text-[11px] text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-500/10 border border-emerald-300 dark:border-emerald-500/20 px-2 py-0.5 rounded-full">open to work</span>
                            @endif
                        </div>
                        @if($portfolio->contact_location)
                        <div class="pl-4 text-slate-400 dark:text-slate-500 text-[12px] flex items-center gap-1.5">
                            <i class="fas fa-map-marker-alt text-brand-accent text-[10px]"></i>
                            {{ $portfolio->contact_location }}
                        </div>
                        @endif

                        <div class="pt-1">
                            <span class="text-emerald-600 dark:text-emerald-400">➜  ~ </span><span class="text-slate-900 dark:text-white">cat capabilities.json</span>
                        </div>
                        <div class="pl-4 leading-[1.8]">
                            <span class="text-amber-600 dark:text-amber-300">{</span><br>
                            @if(!empty($portfolio->tech_stack))
                                @if($isCategorized)
                                    @foreach(array_slice($portfolio->tech_stack, 0, 4) as $cat)
                                    &nbsp;&nbsp;<span class="text-violet-600 dark:text-violet-400">"{{ $cat['name'] ?? 'Stack' }}"</span><span class="text-slate-400 dark:text-slate-600">: [</span>
                                    @php $items = array_slice($cat['items'] ?? [], 0, 3); @endphp
                                    @foreach($items as $j => $item)
                                    @php $itemLabel = is_array($item) ? ($item['text'] ?? '') : $item; @endphp
                                    <span class="text-orange-600 dark:text-orange-400">"{{ $itemLabel }}"</span>@if(!$loop->last)<span class="text-slate-400 dark:text-slate-600">, </span>@endif
                                    @endforeach
                                    @if(count($cat['items'] ?? []) > 3)<span class="text-slate-400 dark:text-slate-500">…</span>@endif
                                    <span class="text-slate-400 dark:text-slate-600">],</span><br>
                                    @endforeach
                                @else
                                    &nbsp;&nbsp;<span class="text-violet-600 dark:text-violet-400">"stack"</span><span class="text-slate-400 dark:text-slate-600">: [</span>
                                    @foreach(array_slice($portfolio->tech_stack, 0, 5) as $j => $tech)
                                    <span class="text-orange-600 dark:text-orange-400">"{{ $tech }}"</span>@if(!$loop->last)<span class="text-slate-400 dark:text-slate-600">, </span>@endif
                                    @endforeach
                                    @if(count($portfolio->tech_stack) > 5)<span class="text-slate-400 dark:text-slate-500">…</span>@endif
                                    <span class="text-slate-400 dark:text-slate-600">],</span><br>
                                @endif
                            @endif
                            @if($portfolio->stat_years)
                            &nbsp;&nbsp;<span class="text-violet-600 dark:text-violet-400">"experience"</span><span class="text-slate-400 dark:text-slate-600">: </span><span class="text-teal-600 dark:text-teal-400">"{{ $portfolio->stat_years }}+ years"</span><span class="text-slate-400 dark:text-slate-600">,</span><br>
                            @endif
                            @if($portfolio->stat_projects)
                            &nbsp;&nbsp;<span class="text-violet-600 dark:text-violet-400">"projects"</span><span class="text-slate-400 dark:text-slate-600">: </span><span class="text-emerald-600 dark:text-emerald-400">{{ $portfolio->stat_projects }}</span><span class="text-slate-400 dark:text-slate-600">,</span><br>
                            @endif
                            <span class="text-amber-600 dark:text-amber-300">}</span>
                        </div>

                        @if($portfolio->hero_available)
                        <div class="pt-1">
                            <span class="text-emerald-600 dark:text-emerald-400">➜  ~ </span><span class="text-slate-900 dark:text-white">status</span>
                        </div>
                        <div class="pl-4">
                            <span class="text-emerald-600 dark:text-emerald-400">✓ </span><span class="text-emerald-700 dark:text-emerald-300">Available for new opportunities</span>
                            <span class="inline-block w-[7px] h-[14px] bg-emerald-600 dark:bg-green-400 ml-0.5 animate-cursor align-middle"></span>
                        </div>
                        @else
                        <div class="pt-1">
                            <span class="text-emerald-600 dark:text-emerald-400">➜  ~ </span><span class="inline-block w-[7px] h-[14px] bg-slate-900 dark:bg-slate-400 animate-cursor align-middle"></span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================
         STATS BAR
    ====================================================== --}}
    @if($portfolio->stat_projects || $portfolio->stat_startups || $portfolio->stat_years)
    <section class="py-14 border-y border-slate-200 dark:border-white/5 bg-white/40 dark:bg-slate-900/40 backdrop-blur-md relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-200 dark:divide-white/10 text-center">
                @if($portfolio->stat_projects)
                <div data-aos="fade-up" data-aos-delay="0">
                    <h3 class="text-4xl md:text-5xl font-display font-bold text-brand-accent mb-2">{{ $portfolio->stat_projects }}+</h3>
                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Projects Shipped</p>
                </div>
                @endif
                @if($portfolio->stat_startups)
                <div class="pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-4xl md:text-5xl font-display font-bold text-brand-accent mb-2">{{ $portfolio->stat_startups }}+</h3>
                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Startups Served</p>
                </div>
                @endif
                @if($portfolio->stat_years)
                <div class="pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-4xl md:text-5xl font-display font-bold text-brand-accent mb-2">{{ $portfolio->stat_years }}+</h3>
                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Years Experience</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ======================================================
         TECH STACK / ABOUT
    ====================================================== --}}
    @if(!empty($portfolio->tech_stack))
    <section id="about" class="py-28 bg-white/50 dark:bg-slate-900/40 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center md:text-left" data-aos="fade-up">
                <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// tech stack</span>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-3">What I actually use.</h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto md:mx-0">
                    No half-baked demos here — these are tools used in production, under real pressure.
                </p>
            </div>

            @php
            $isCategorized = isset($portfolio->tech_stack[0]['name']);
            $colorMap = [
                'blue'   => ['blob' => 'bg-blue-500/10 group-hover:bg-blue-500/20',    'icon_wrap' => 'bg-blue-100 dark:bg-blue-500/10',    'icon_txt' => 'text-blue-600 dark:text-blue-400'],
                'violet' => ['blob' => 'bg-violet-500/10 group-hover:bg-violet-500/20','icon_wrap' => 'bg-violet-100 dark:bg-violet-500/10', 'icon_txt' => 'text-violet-600 dark:text-violet-400'],
                'emerald'=> ['blob' => 'bg-emerald-500/10 group-hover:bg-emerald-500/20','icon_wrap'=> 'bg-emerald-50 dark:bg-emerald-500/10','icon_txt' => 'text-emerald-600 dark:text-emerald-400'],
                'red'    => ['blob' => 'bg-red-500/10 group-hover:bg-red-500/20',      'icon_wrap' => 'bg-red-50 dark:bg-red-500/10',       'icon_txt' => 'text-red-500 dark:text-red-400'],
                'amber'  => ['blob' => 'bg-amber-500/10 group-hover:bg-amber-500/20',  'icon_wrap' => 'bg-amber-50 dark:bg-amber-500/10',   'icon_txt' => 'text-amber-600 dark:text-amber-400'],
                'cyan'   => ['blob' => 'bg-cyan-500/10 group-hover:bg-cyan-500/20',    'icon_wrap' => 'bg-cyan-50 dark:bg-cyan-500/10',     'icon_txt' => 'text-cyan-600 dark:text-cyan-400'],
                'orange' => ['blob' => 'bg-orange-500/10 group-hover:bg-orange-500/20','icon_wrap' => 'bg-orange-50 dark:bg-orange-500/10', 'icon_txt' => 'text-orange-500 dark:text-orange-400'],
                'pink'   => ['blob' => 'bg-pink-500/10 group-hover:bg-pink-500/20',    'icon_wrap' => 'bg-pink-50 dark:bg-pink-500/10',     'icon_txt' => 'text-pink-500 dark:text-pink-400'],
            ];
            $aosDelays = [0, 80, 160, 240, 320, 400];
            @endphp

            @if($isCategorized)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($portfolio->tech_stack as $ci => $cat)
                @php
                $clr = $colorMap[$cat['color'] ?? 'blue'] ?? $colorMap['blue'];
                $delay = $aosDelays[$ci] ?? ($ci * 80);
                $catIconType = $cat['icon_type'] ?? 'fa';
                $catIconVal  = $cat['icon'] ?? 'fas fa-code';
                $catIconImg  = ($catIconType === 'image' && !empty($catIconVal))
                    ? (str_starts_with($catIconVal, 'http') ? $catIconVal : asset('storage/' . $catIconVal))
                    : null;
                @endphp
                <div class="glass-card p-8 rounded-2xl relative overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                    <div class="absolute -top-10 -right-10 w-40 h-40 {{ $clr['blob'] }} rounded-full blur-2xl transition-all pointer-events-none"></div>
                    <div class="relative">
                        <div class="w-11 h-11 {{ $clr['icon_wrap'] }} rounded-xl flex items-center justify-center mb-5 {{ $clr['icon_txt'] }}">
                            @if($catIconImg)
                            <img src="{{ $catIconImg }}" alt="" class="w-6 h-6 object-contain">
                            @else
                            <i class="{{ $catIconVal }} text-xl"></i>
                            @endif
                        </div>
                        <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">{{ $cat['name'] }}</h3>
                        @if(!empty($cat['items']))
                        <ul class="space-y-2.5 text-[14px] text-slate-500 dark:text-slate-400">
                            @foreach($cat['items'] as $item)
                            @php
                            $itemText     = is_array($item) ? ($item['text'] ?? '') : $item;
                            $itemIconType = is_array($item) ? ($item['icon_type'] ?? 'fa') : 'fa';
                            $itemIcon     = is_array($item) ? ($item['icon'] ?? '') : '';
                            $itemImgSrc   = ($itemIconType === 'image' && !empty($itemIcon))
                                ? (str_starts_with($itemIcon, 'http') ? $itemIcon : asset('storage/' . $itemIcon))
                                : null;
                            @endphp
                            <li class="flex items-center gap-3">
                                @if($itemImgSrc)
                                <img src="{{ $itemImgSrc }}" alt="" class="w-4 h-4 object-contain flex-shrink-0">
                                @elseif($itemIconType === 'fa' && !empty($itemIcon))
                                <i class="{{ $itemIcon }} {{ $clr['icon_txt'] }} w-4 flex-shrink-0"></i>
                                @elseif($itemIconType !== 'none')
                                <i class="{{ $cat['icon'] ?? 'fas fa-code' }} {{ $clr['icon_txt'] }} w-4 flex-shrink-0 opacity-70"></i>
                                @endif
                                {{ $itemText }}
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-wrap gap-3" data-aos="fade-up" data-aos-delay="100">
                @foreach($portfolio->tech_stack as $tech)
                <span class="px-5 py-2.5 glass-card rounded-full text-sm font-semibold text-slate-700 dark:text-slate-200">
                    {{ is_string($tech) ? $tech : ($tech['name'] ?? '') }}
                </span>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ======================================================
         EXPERIENCE
    ====================================================== --}}
    @if(!empty($portfolio->experience))
    <section id="experience" class="py-24 relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center md:text-left" data-aos="fade-up">
                <span class="text-brand-accent font-bold tracking-wider uppercase text-sm font-mono">// experience</span>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3">Professional Path</h2>
            </div>
            <div class="space-y-8">
                @foreach($portfolio->experience as $i => $exp)
                <div class="glass-card p-8 md:p-10 rounded-[2rem] relative overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-all duration-500 pointer-events-none"></div>
                    <div class="flex flex-col md:flex-row gap-6 md:gap-12 relative z-10">
                        <div class="md:w-1/3 flex-shrink-0 border-b md:border-b-0 md:border-r border-slate-200 dark:border-white/10 pb-6 md:pb-0 md:pr-8">
                            <span class="inline-block px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 text-xs font-bold font-mono tracking-wide mb-4">
                                {{ $exp['period'] ?? '' }}
                            </span>
                            <h3 class="text-2xl font-display font-bold text-slate-900 dark:text-white mb-2">{{ $exp['company'] ?? '' }}</h3>
                        </div>
                        <div class="md:w-2/3 md:pt-1">
                            <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-4">{{ $exp['title'] ?? '' }}</h4>
                            @if(!empty($exp['description']))
                            <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ======================================================
         PROJECTS / FEATURED WORK
    ====================================================== --}}
    @if(!empty($portfolio->projects))
    <section id="projects" class="py-28 relative bg-white/50 dark:bg-slate-900/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-14" data-aos="fade-right">
                <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// work</span>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3">Featured Work.</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($portfolio->projects as $i => $project)
                @php
                $imageVal = $project['image'] ?? '';
                $imageSrc = $imageVal
                    ? (str_starts_with($imageVal, 'http') ? $imageVal : asset('storage/' . $imageVal))
                    : null;
                @endphp

                @if($imageSrc)
                {{-- Image-overlay card --}}
                <div class="project-img-card group relative rounded-2xl overflow-hidden h-72 cursor-pointer shadow-xl" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <img src="{{ $imageSrc }}" alt="{{ $project['name'] ?? 'Project' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent flex flex-col justify-end p-7">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-display font-bold text-white">{{ $project['name'] ?? 'Project' }}</h3>
                            <div class="flex items-center gap-2">
                                @if(!empty($project['github']))
                                <a href="{{ $project['github'] }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 backdrop-blur flex items-center justify-center text-white hover:bg-white/25 transition-colors">
                                    <i class="fab fa-github text-sm"></i>
                                </a>
                                @endif
                                @if(!empty($project['url']))
                                <a href="{{ $project['url'] }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 backdrop-blur flex items-center justify-center text-white hover:bg-white/25 transition-colors">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @if(!empty($project['tech']))
                        <div class="flex flex-wrap gap-1.5 mb-2">
                            @foreach(explode(',', $project['tech']) as $tech)
                            <span class="chip bg-white/15 text-white/90 backdrop-blur">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($project['description']))
                        <div class="reveal">
                            <p class="text-[13px] text-slate-300 leading-relaxed">{{ $project['description'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                {{-- Glass card fallback --}}
                <div class="glass-card rounded-2xl p-7 flex flex-col gap-4" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div>
                        <h3 class="text-xl font-display font-bold text-slate-900 dark:text-white mb-2">{{ $project['name'] ?? 'Project' }}</h3>
                        @if(!empty($project['description']))
                        <p class="text-[15px] text-slate-500 dark:text-slate-400 leading-relaxed">{{ $project['description'] }}</p>
                        @endif
                    </div>
                    @if(!empty($project['tech']))
                    <div class="flex flex-wrap gap-1.5">
                        @foreach(explode(',', $project['tech']) as $tech)
                        <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                    @endif
                    @if(!empty($project['github']) || !empty($project['url']))
                    <div class="flex items-center gap-3 mt-auto pt-2 border-t border-slate-200 dark:border-white/10">
                        @if(!empty($project['github']))
                        <a href="{{ $project['github'] }}" target="_blank" class="flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors font-medium">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                        @endif
                        @if(!empty($project['url']))
                        <a href="{{ $project['url'] }}" target="_blank" class="flex items-center gap-1.5 text-sm text-brand-accent hover:opacity-75 transition-opacity font-medium">
                            <i class="fas fa-external-link-alt text-xs"></i> Live demo
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                @endif

                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ======================================================
         CONTACT
    ====================================================== --}}
    @if($portfolio->contact_email)
    <livewire:contact :portfolio="$portfolio" />
    @endif

    {{-- FOOTER --}}
    <footer class="py-8 border-t border-slate-200 dark:border-white/5 text-center">
        <p class="text-sm text-slate-400 dark:text-slate-500">
            Built with <a href="{{ url('/') }}" class="text-brand-accent hover:underline font-medium">Folio</a> &mdash; your portfolio, live in minutes.
        </p>
    </footer>

</main>

{{-- Chat widget (fixed bottom-right, self-positioned) --}}
<livewire:chat-widget />

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 });

    function toggleTheme() {
        const h = document.documentElement;
        const isDark = h.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
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

@livewireScripts
</body>
</html>
