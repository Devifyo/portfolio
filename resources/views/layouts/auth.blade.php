<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Folio' }}</title>

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
                        brand: { dark: '#0a0f1e', light: '#f5f4f0', accent: '#2563eb', accent2: '#7c3aed' }
                    },
                }
            }
        }
    </script>

    <style>
        html, body { height: 100%; }

        .input-line {
            width: 100%;
            padding: 0.75rem 0;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid #e2e8f0;
            color: #0f172a;
            font-size: 0.9375rem;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        html.dark .input-line {
            border-bottom-color: rgba(255,255,255,0.12);
            color: #f1f5f9;
        }
        .input-line::placeholder { color: #94a3b8; }
        .input-line:focus { border-bottom-color: #2563eb; }
        .input-line.error { border-bottom-color: #ef4444; }

        .btn-primary {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 0.875rem 1.5rem;
            background: #0f172a; color: white;
            border-radius: 10px; font-weight: 700; font-size: 0.9375rem;
            transition: opacity 0.15s, transform 0.15s;
            border: none; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }
        html.dark .btn-primary { background: white; color: #0f172a; }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }

        /* Left panel dot texture */
        .dot-texture {
            background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Noise overlay */
        .noise::after {
            content: '';
            position: absolute; inset: 0;
            pointer-events: none; opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }
    </style>

    <script>(function(){const t=localStorage.getItem('theme');if(t==='dark')document.documentElement.classList.add('dark');})()</script>

    @livewireStyles
</head>
<body class="h-full bg-white dark:bg-[#0a0f1e] font-sans antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
