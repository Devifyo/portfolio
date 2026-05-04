<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Full Stack & AI Engineer — MCP Servers, Laravel, Django, Vue, React.">
    <title>{{ $title ?? 'Dev Portfolio | Full Stack & AI Engineer' }}</title>

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
                        sans: ['DM Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            dark: '#0a0f1e',
                            light: '#f5f4f0',
                            accent: '#2563eb',
                            laravel: '#FF2D20',
                            django: '#092E20',
                            vue: '#42b883',
                            react: '#61DAFB',
                            ai: '#7c3aed'
                        }
                    },
                    animation: {
                        'blob': 'blob 9s infinite',
                        'cursor': 'cursor .75s step-end infinite',
                        'spin-slow': 'spin 14s linear infinite',
                        'bounce-slow': 'bounce 3s infinite',
                        'float': 'float 6s ease-in-out infinite',
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
            border-color: rgba(37,99,235,0.4);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(37,99,235,0.08);
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

        #chat-window {
            transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), opacity 0.2s ease;
            transform-origin: bottom right;
        }
        #chat-window.chat-closed {
            transform: scale(0.88) translateY(8px);
            opacity: 0;
            pointer-events: none;
        }
        #chat-window.chat-open {
            transform: scale(1) translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        .star-anim { transition: transform 0.15s, color 0.15s; cursor: pointer; }
        .star-anim:hover { transform: scale(1.25); color: #fbbf24; }

        .chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600;
            letter-spacing: 0.02em;
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

    <x-navigation />

    <main class="relative z-10">
        {{ $slot }}
    </main>

    <livewire:chat-widget />

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });
        document.addEventListener('livewire:navigated', () => AOS.refreshHard());

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

    @stack('scripts')

    @livewireScripts
</body>
</html>