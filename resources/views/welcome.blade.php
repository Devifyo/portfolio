<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Full Stack & AI Engineer — MCP Servers, Laravel, Django, Vue, React.">
    <title>Dev Portfolio | Full Stack & AI Engineer</title>
    
    <!-- Fonts: Syne (display) + DM Sans (body) + JetBrains Mono (code) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        cursor: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-12px)' },
                        }
                    },
                }
            }
        }
    </script>

    <style>
        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f5f4f0; }
        html.dark ::-webkit-scrollbar-track { background: #0a0f1e; }
        ::-webkit-scrollbar-thumb { background: #c8c5bc; border-radius: 3px; }
        html.dark ::-webkit-scrollbar-thumb { background: #2a3352; }

        /* ── Glass ── */
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

        /* ── Typography ── */
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(135deg, #2563eb 0%, #7c3aed 50%, #db2777 100%);
        }
        h1, h2, h3 { font-family: 'Syne', sans-serif; }

        /* ── Grid bg ── */
        .bg-grid {
            background-image:
                linear-gradient(to right, rgba(37,99,235,0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(37,99,235,0.04) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
        }

        /* ── Chat widget fixes ── */
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

        /* ── Star hover ── */
        .star-anim { transition: transform 0.15s, color 0.15s; cursor: pointer; }
        .star-anim:hover { transform: scale(1.25); color: #fbbf24; }

        /* ── Chip style ── */
        .chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600;
            letter-spacing: 0.02em;
        }

        /* Noise texture overlay for depth */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 1;
            pointer-events: none;
            opacity: 0.018;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="bg-brand-light dark:bg-brand-dark text-slate-600 dark:text-slate-300 font-sans antialiased overflow-x-hidden selection:bg-brand-accent/20 selection:text-brand-accent transition-colors duration-300 relative">

    <!-- Grid Background -->
    <div class="fixed inset-0 pointer-events-none z-0 bg-grid"></div>

    <!-- ── Navigation ── -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0 cursor-pointer group relative z-50" onclick="switchView('home')">
                    <span class="font-mono text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand-accent transition-colors">
                        &lt;Dev/<span class="text-brand-accent">_</span>&gt;
                    </span>
                </div>
                
                <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center space-x-8">
                    <a href="#about" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Stack</a>
                    <a href="#projects" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Work</a>
                    <a href="#experience" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Timeline</a>
                </div>

                <div class="hidden md:flex items-center gap-3 relative z-50">
                    <button onclick="toggleTheme()" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors" aria-label="Toggle Theme">
                        <i class="fas fa-sun hidden dark:block text-yellow-400 text-sm"></i>
                        <i class="fas fa-moon block dark:hidden text-slate-500 text-sm"></i>
                    </button>
                    <a href="https://github.com" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-white/10 transition-colors text-slate-500 dark:text-slate-400">
                        <i class="fab fa-github text-lg"></i>
                    </a>
                    <div class="h-5 w-px bg-slate-300 dark:bg-white/10 mx-1"></div>
                    <a href="#contact" class="px-5 py-2 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-80 transition-all shadow-md">
                        Hire Me
                    </a>
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
                <a href="#about" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Stack</a>
                <a href="#projects" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Work</a>
                <a href="#experience" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Timeline</a>
                <a href="#contact" class="block px-3 py-3 rounded-lg text-base font-bold text-brand-accent">Hire Me</a>
            </div>
        </div>
    </nav>

    <!-- ════════════════════════════════════════
         HOME VIEW
    ════════════════════════════════════════ -->
    <div id="home-view" class="transition-opacity duration-300 relative z-10">

        <!-- ── Hero ── -->
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
            <div class="absolute top-10 -left-20 w-[500px] h-[500px] bg-blue-500 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.08] dark:opacity-[0.12] animate-blob"></div>
            <div class="absolute top-20 -right-20 w-[400px] h-[400px] bg-violet-500 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.07] dark:opacity-[0.10] animate-blob" style="animation-delay:2.5s"></div>
            <div class="absolute -bottom-10 left-1/3 w-[350px] h-[350px] bg-cyan-400 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.06] dark:opacity-[0.08] animate-blob" style="animation-delay:5s"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-16 items-center">
                
                <!-- Left: Text -->
                <div data-aos="fade-right" data-aos-duration="900">
                    
                    <!-- Profile & Status -->
                    <div class="inline-flex items-center gap-3 mb-8 px-2 py-2 pr-5 rounded-full bg-white/70 dark:bg-white/5 border border-slate-200 dark:border-white/10 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?fit=crop&w=150&h=150" alt="Alex Mercer" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-white/20">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-900 dark:text-white leading-none">Alex Mercer</span>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="flex h-1.5 w-1.5 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                </span>
                                <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Available for work</span>
                            </div>
                        </div>
                    </div>

                    <h1 class="text-5xl md:text-[64px] font-display font-bold text-slate-900 dark:text-white tracking-tight mb-6 leading-[1.08]">
                        I build things<br>
                        <span class="text-gradient">that actually work.</span>
                    </h1>

                    <p class="text-[17px] text-slate-500 dark:text-slate-400 mb-9 max-w-md leading-relaxed">
                        Senior full-stack engineer with a soft spot for AI infrastructure. I've shipped everything from <span class="text-slate-700 dark:text-slate-200 font-medium">Laravel monoliths</span> to multi-agent systems talking through <span class="text-slate-700 dark:text-slate-200 font-medium">MCP servers</span>.
                    </p>
                    
                    <div class="flex flex-wrap gap-3">
                        <button onclick="switchView('projects')" class="px-7 py-3.5 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-brand-dark text-sm font-bold hover:opacity-85 transition-all shadow-md flex items-center gap-2">
                            See my work <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                        <a href="#contact" class="px-7 py-3.5 rounded-lg border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white text-sm font-medium hover:bg-slate-100 dark:hover:bg-white/8 transition-all">
                            Get in touch
                        </a>
                    </div>

                    <!-- Rating -->
                    <div class="mt-9 py-3 px-4 rounded-xl bg-white/60 dark:bg-slate-800/40 border border-slate-200 dark:border-white/5 w-fit shadow-sm" data-aos="fade-up" data-aos-delay="150">
                        <div class="flex items-center gap-4">
                            <div class="flex text-slate-300 dark:text-slate-700 gap-1 text-base" id="user-rating-stars">
                                <i class="fas fa-star star-anim" data-value="1" onclick="submitRating(1)"></i>
                                <i class="fas fa-star star-anim" data-value="2" onclick="submitRating(2)"></i>
                                <i class="fas fa-star star-anim" data-value="3" onclick="submitRating(3)"></i>
                                <i class="fas fa-star star-anim" data-value="4" onclick="submitRating(4)"></i>
                                <i class="fas fa-star star-anim" data-value="5" onclick="submitRating(5)"></i>
                            </div>
                            <div class="flex flex-col border-l border-slate-200 dark:border-white/10 pl-4">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-bold text-slate-900 dark:text-white text-sm">4.9</span>
                                    <span class="text-xs text-slate-400">/ 5</span>
                                </div>
                                <span id="rating-label" class="text-xs text-slate-400">(128 reviews)</span>
                                <span id="rating-thanks" class="hidden text-xs font-semibold text-emerald-500">Thanks!</span>
                            </div>
                        </div>
                    </div>

                    <!-- Social proof -->
                    <div class="mt-8 flex items-center gap-5 text-slate-400">
                        <div class="flex -space-x-2.5">
                            <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700 border-2 border-white dark:border-brand-dark flex items-center justify-center text-[11px] text-slate-700 dark:text-white font-bold">L</div>
                            <div class="w-9 h-9 rounded-full bg-slate-300 dark:bg-slate-600 border-2 border-white dark:border-brand-dark flex items-center justify-center text-[11px] text-slate-700 dark:text-white font-bold">A</div>
                            <div class="w-9 h-9 rounded-full bg-slate-400 dark:bg-slate-500 border-2 border-white dark:border-brand-dark flex items-center justify-center text-[11px] text-white font-bold">+8</div>
                        </div>
                        <div>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-white">10+ startups shipped</span>
                            <span class="text-xs text-slate-400">across fintech, SaaS, edtech</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Terminal -->
                <div class="relative group" data-aos="fade-left" data-aos-duration="900" data-aos-delay="100">
                    <div class="absolute -inset-1.5 bg-gradient-to-br from-blue-500 to-violet-600 rounded-2xl blur-lg opacity-20 group-hover:opacity-35 transition-all duration-700"></div>
                    
                    <div class="relative glass rounded-2xl overflow-hidden shadow-2xl">
                        <!-- Terminal titlebar -->
                        <div class="bg-slate-100 dark:bg-[#0d1117] px-4 py-3 flex items-center gap-3 border-b border-slate-200 dark:border-white/5">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="flex-1 text-center text-[11px] text-slate-400 font-mono">~/dev/agent_builder.py</div>
                        </div>

                        <!-- Terminal body -->
                        <div class="p-6 font-mono text-[13px] h-[340px] bg-[#fcfcfc] dark:bg-[#080d16] overflow-hidden relative">
                            <!-- Faint robot watermark -->
                            <div class="absolute bottom-4 right-4 opacity-[0.04] select-none pointer-events-none">
                                <i class="fas fa-robot text-8xl"></i>
                            </div>

                            <p class="text-emerald-600 dark:text-emerald-400 mb-1">➜  ~  whoami</p>
                            <p class="text-slate-600 dark:text-slate-300 mb-4">alex_mercer (senior ai & full-stack engineer)</p>
                            
                            <p class="text-emerald-600 dark:text-emerald-400 mb-1">➜  ~  cat capabilities.json</p>
                            <div class="text-amber-600 dark:text-amber-300">{</div>
                            <div class="pl-4 space-y-0.5">
                                <div><span class="text-violet-600 dark:text-violet-400">"backend"</span>: [<span class="text-orange-600 dark:text-orange-400">"Laravel"</span>, <span class="text-green-600 dark:text-green-400">"Django"</span>, <span class="text-teal-600 dark:text-teal-400">"FastAPI"</span>],</div>
                                <div><span class="text-violet-600 dark:text-violet-400">"frontend"</span>: [<span class="text-cyan-600 dark:text-cyan-400">"React"</span>, <span class="text-emerald-600 dark:text-emerald-400">"Vue 3"</span>],</div>
                                <div><span class="text-violet-600 dark:text-violet-400">"ai_infra"</span>: [</div>
                                <div class="pl-4">
                                    <span class="text-blue-500 dark:text-blue-300">"MCP Servers"</span>,
                                    <span class="text-blue-500 dark:text-blue-300">"LangChain"</span>,
                                    <span class="text-blue-500 dark:text-blue-300">"RAG"</span>,
                                    <span class="text-blue-500 dark:text-blue-300">"Ollama"</span>
                                </div>
                                <div>]</div>
                            </div>
                            <div class="text-amber-600 dark:text-amber-300 mb-4">}</div>

                            <div>
                                <span class="text-emerald-600 dark:text-emerald-400">➜  ~ </span>
                                <span id="typing-text" class="text-slate-900 dark:text-white"></span><!--
                                --><span class="animate-cursor bg-slate-900 dark:bg-green-400 w-[7px] h-[14px] inline-block align-middle"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Stats Section ── -->
        <section class="py-12 border-y border-slate-200 dark:border-white/5 bg-white/40 dark:bg-slate-900/40 backdrop-blur-md relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-200 dark:divide-white/10 text-center">
                    <div data-aos="fade-up" data-aos-delay="0">
                        <h3 class="text-4xl md:text-5xl font-display font-bold text-brand-accent mb-2">50+</h3>
                        <p class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Projects Shipped</p>
                    </div>
                    <div class="pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-4xl md:text-5xl font-display font-bold text-brand-accent mb-2">10+</h3>
                        <p class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Startups Served</p>
                    </div>
                    <div class="pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-4xl md:text-5xl font-display font-bold text-brand-accent mb-2">99%</h3>
                        <p class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Production Uptime</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Tech Stack ── -->
        <section id="about" class="py-28 bg-white/50 dark:bg-slate-900/40 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center md:text-left" data-aos="fade-up">
                    <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// tech stack</span>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-3">What I actually use.</h2>
                    <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto md:mx-0">
                        No half-baked demos here — these are tools I've used in production, under real pressure.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- AI Engineering -->
                    <div class="glass-card p-8 rounded-2xl relative overflow-hidden group" data-aos="fade-up">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-violet-500/10 rounded-full blur-2xl group-hover:bg-violet-500/20 transition-all"></div>
                        <div class="relative">
                            <div class="w-11 h-11 bg-violet-100 dark:bg-violet-500/10 rounded-xl flex items-center justify-center mb-5 text-violet-600 dark:text-violet-400">
                                <i class="fas fa-brain text-xl"></i>
                            </div>
                            <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">AI Engineering</h3>
                            <ul class="space-y-2.5 text-[14px] text-slate-500 dark:text-slate-400">
                                <li class="flex items-center gap-3"><i class="fas fa-network-wired text-violet-500 w-4"></i> MCP Servers (protocol design + hosting)</li>
                                <li class="flex items-center gap-3"><i class="fas fa-robot text-violet-400 w-4"></i> Autonomous agents (tool-use, memory)</li>
                                <li class="flex items-center gap-3"><i class="fas fa-database text-violet-300 w-4"></i> RAG pipelines w/ vector search</li>
                                <li class="flex items-center gap-3"><i class="fas fa-microchip text-slate-400 w-4"></i> Local LLMs via Ollama</li>
                            </ul>
                        </div>
                    </div>

                    <!-- PHP / Laravel -->
                    <div class="glass-card p-8 rounded-2xl relative overflow-hidden group" data-aos="fade-up" data-aos-delay="80">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-500/10 rounded-full blur-2xl group-hover:bg-red-500/20 transition-all"></div>
                        <div class="relative">
                            <div class="w-11 h-11 bg-red-50 dark:bg-red-500/10 rounded-xl flex items-center justify-center mb-5 text-red-500">
                                <i class="fab fa-laravel text-xl"></i>
                            </div>
                            <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">PHP Ecosystem</h3>
                            <ul class="space-y-2.5 text-[14px] text-slate-500 dark:text-slate-400">
                                <li class="flex items-center gap-3"><i class="fab fa-laravel text-red-500 w-4"></i> Laravel — daily driver since v5</li>
                                <li class="flex items-center gap-3"><i class="fas fa-bolt text-pink-500 w-4"></i> Livewire for reactive UIs</li>
                                <li class="flex items-center gap-3"><i class="fas fa-cube text-slate-500 w-4"></i> FilamentPHP admin panels</li>
                                <li class="flex items-center gap-3"><i class="fas fa-server text-orange-400 w-4"></i> MySQL query optimisation</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Python -->
                    <div class="glass-card p-8 rounded-2xl relative overflow-hidden group" data-aos="fade-up" data-aos-delay="160">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
                        <div class="relative">
                            <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl flex items-center justify-center mb-5 text-emerald-600 dark:text-emerald-400">
                                <i class="fab fa-python text-xl"></i>
                            </div>
                            <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">Python Ecosystem</h3>
                            <ul class="space-y-2.5 text-[14px] text-slate-500 dark:text-slate-400">
                                <li class="flex items-center gap-3"><span class="w-4 h-4 rounded-full border-2 border-emerald-600 bg-emerald-800/30 inline-block flex-shrink-0"></span> Django + DRF</li>
                                <li class="flex items-center gap-3"><i class="fas fa-rocket text-teal-500 w-4"></i> FastAPI microservices</li>
                                <li class="flex items-center gap-3"><i class="fas fa-flask text-slate-600 dark:text-slate-300 w-4"></i> Flask for quick API work</li>
                                <li class="flex items-center gap-3"><i class="fas fa-database text-blue-400 w-4"></i> PostgreSQL + Alembic</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Frontend -->
                    <div class="glass-card p-8 rounded-2xl relative overflow-hidden group" data-aos="fade-up" data-aos-delay="240">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-2xl group-hover:bg-cyan-500/20 transition-all"></div>
                        <div class="relative">
                            <div class="w-11 h-11 bg-cyan-50 dark:bg-cyan-500/10 rounded-xl flex items-center justify-center mb-5 text-cyan-600 dark:text-cyan-400">
                                <i class="fab fa-js text-xl"></i>
                            </div>
                            <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">Frontend</h3>
                            <ul class="space-y-2.5 text-[14px] text-slate-500 dark:text-slate-400">
                                <li class="flex items-center gap-3"><i class="fab fa-vuejs text-brand-vue w-4"></i> Vue.js 3 (Composition API)</li>
                                <li class="flex items-center gap-3"><i class="fab fa-react text-brand-react w-4"></i> React + Next.js</li>
                                <li class="flex items-center gap-3"><i class="fas fa-wind text-cyan-400 w-4"></i> Tailwind CSS</li>
                                <li class="flex items-center gap-3"><i class="fab fa-js text-yellow-400 w-4"></i> TypeScript</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Clean Minimal Timeline ── -->
        <section id="experience" class="py-24 relative">
             <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="mb-16 text-center md:text-left" data-aos="fade-up">
                    <span class="text-brand-accent font-bold tracking-wider uppercase text-sm font-mono">// experience</span>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-4">Professional Path</h2>
                    <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto md:mx-0">
                        A track record of building and scaling systems. No fluff, just shipped code.
                    </p>
                </div>

                <div class="space-y-8">
                    
                    <!-- Job 1 -->
                    <div class="glass-card p-8 md:p-10 rounded-[2rem] relative overflow-hidden group" data-aos="fade-up">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-all duration-500"></div>
                        <div class="flex flex-col md:flex-row gap-6 md:gap-12 relative z-10">
                            <!-- Left: Meta -->
                            <div class="md:w-1/3 flex-shrink-0 border-b md:border-b-0 md:border-r border-slate-200 dark:border-white/10 pb-6 md:pb-0 md:pr-8">
                                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 text-xs font-bold font-mono tracking-wide mb-4">
                                    2023 — Present
                                </span>
                                <h3 class="text-2xl font-display font-bold text-slate-900 dark:text-white mb-2">TechCorp Solutions</h3>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <i class="fas fa-globe-americas opacity-70"></i> Remote
                                </p>
                            </div>
                            <!-- Right: Content -->
                            <div class="md:w-2/3 md:pt-1">
                                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-4">Senior Full Stack Architect</h4>
                                <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                                    Architecting scalable microservices for a high-traffic fintech platform. Spearheaded the migration of legacy PHP monoliths to a distributed <strong>Python (FastAPI)</strong> and <strong>Laravel</strong> architecture. Introduced <strong>MCP Servers</strong> to allow secure AI-database interactions for internal analytics bots.
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">System Design</span>
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">AI Agents</span>
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Team Leadership</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job 2 -->
                    <div class="glass-card p-8 md:p-10 rounded-[2rem] relative overflow-hidden group" data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl group-hover:bg-purple-500/10 transition-all duration-500"></div>
                        <div class="flex flex-col md:flex-row gap-6 md:gap-12 relative z-10">
                            <!-- Left: Meta -->
                            <div class="md:w-1/3 flex-shrink-0 border-b md:border-b-0 md:border-r border-slate-200 dark:border-white/10 pb-6 md:pb-0 md:pr-8">
                                <span class="inline-block px-3 py-1 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold font-mono tracking-wide mb-4">
                                    2020 — 2023
                                </span>
                                <h3 class="text-2xl font-display font-bold text-slate-900 dark:text-white mb-2">Digital Agency X</h3>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <i class="fas fa-building opacity-70"></i> Hybrid
                                </p>
                            </div>
                            <!-- Right: Content -->
                            <div class="md:w-2/3 md:pt-1">
                                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-4">Senior Laravel Developer</h4>
                                <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                                    Delivered 15+ bespoke web applications for enterprise clients. Specialized in the <strong>TALL stack</strong> (Tailwind, Alpine, Laravel, Livewire) to rapidly build reactive SPAs without the complexity of a full frontend framework. Optimized SQL queries reducing load times by 40%.
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Laravel</span>
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Livewire</span>
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Vue.js</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job 3 -->
                    <div class="glass-card p-8 md:p-10 rounded-[2rem] relative overflow-hidden group" data-aos="fade-up" data-aos-delay="200">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl group-hover:bg-teal-500/10 transition-all duration-500"></div>
                        <div class="flex flex-col md:flex-row gap-6 md:gap-12 relative z-10">
                            <!-- Left: Meta -->
                            <div class="md:w-1/3 flex-shrink-0 border-b md:border-b-0 md:border-r border-slate-200 dark:border-white/10 pb-6 md:pb-0 md:pr-8">
                                <span class="inline-block px-3 py-1 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold font-mono tracking-wide mb-4">
                                    2018 — 2020
                                </span>
                                <h3 class="text-2xl font-display font-bold text-slate-900 dark:text-white mb-2">Fintech Startup Y</h3>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt opacity-70"></i> On-site
                                </p>
                            </div>
                            <!-- Right: Content -->
                            <div class="md:w-2/3 md:pt-1">
                                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-4">Backend Developer</h4>
                                <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                                    Built robust payment processing APIs using <strong>Django REST Framework</strong>. Implemented KYC verification flows and secure ledger systems handling millions in daily transaction volume.
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Python</span>
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">PostgreSQL</span>
                                    <span class="chip bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Docker</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
             </div>
        </section>

        <!-- ── Featured Work ── -->
        <section id="projects" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end mb-14 gap-4">
                    <div data-aos="fade-right">
                        <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// work</span>
                        <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-2">A few highlights.</h2>
                        <p class="text-slate-500 dark:text-slate-400">Where AI meets robust engineering.</p>
                    </div>
                    <button onclick="switchView('projects')" class="flex items-center gap-2 text-brand-accent text-sm font-semibold hover:opacity-75 transition-opacity">
                        Full archive <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="fade-up">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/50 to-transparent z-10"></div>
                        <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="AI Agent" class="w-full h-80 object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute bottom-0 left-0 p-7 z-20 w-full">
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="chip bg-violet-600/90 text-white">MCP Server</span>
                                <span class="chip bg-teal-500/90 text-slate-900">FastAPI</span>
                                <span class="chip bg-slate-700/90 text-white">LangChain</span>
                            </div>
                            <h3 class="text-xl font-display font-bold text-white mb-2 group-hover:text-brand-accent transition-colors">Autonomous SQL Agent</h3>
                            <p class="text-slate-300 text-[13px] max-h-0 overflow-hidden group-hover:max-h-20 transition-all duration-500 leading-relaxed">
                                Internal AI agent that queries databases safely via MCP protocol and posts business reports to Slack — no human in the loop.
                            </p>
                        </div>
                    </div>

                    <div class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="fade-up" data-aos-delay="80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/50 to-transparent z-10"></div>
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="SaaS Dashboard" class="w-full h-80 object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute bottom-0 left-0 p-7 z-20 w-full">
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="chip bg-red-600/90 text-white">Laravel</span>
                                <span class="chip bg-pink-500/90 text-white">Livewire</span>
                                <span class="chip bg-cyan-400/90 text-slate-900">React</span>
                            </div>
                            <h3 class="text-xl font-display font-bold text-white mb-2 group-hover:text-brand-accent transition-colors">Enterprise CRM</h3>
                            <p class="text-slate-300 text-[13px] max-h-0 overflow-hidden group-hover:max-h-20 transition-all duration-500 leading-relaxed">
                                Multi-tenant SaaS with real-time analytics, Stripe billing, and a FilamentPHP admin panel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Contact ── -->
        <section id="contact" class="py-28 relative overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="glass rounded-3xl overflow-hidden shadow-2xl" data-aos="fade-up">
                    <div class="grid md:grid-cols-5">
                        
                        <!-- Left -->
                        <div class="md:col-span-2 bg-slate-50 dark:bg-white/[0.03] p-10 flex flex-col justify-between relative overflow-hidden border-r border-slate-200 dark:border-white/5">
                            <div class="absolute -top-16 -right-16 w-48 h-48 bg-blue-400/10 rounded-full blur-3xl"></div>
                            <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-violet-400/10 rounded-full blur-3xl"></div>

                            <div class="relative">
                                <h2 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-4 leading-tight">
                                    Got something<br/>interesting? <span class="text-brand-accent">Let's talk.</span>
                                </h2>
                                <p class="text-[14px] text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">
                                    Whether it's a greenfield system or a legacy codebase that needs untangling — I'm in.
                                </p>
                                
                                <div class="space-y-5">
                                    <div class="flex items-center gap-3 group cursor-pointer">
                                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                                            <i class="fas fa-envelope text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-0.5">Email</p>
                                            <p class="text-slate-700 dark:text-slate-200 text-sm font-medium">hello@architect.dev</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-violet-500">
                                            <i class="fas fa-globe text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-0.5">Location</p>
                                            <p class="text-slate-700 dark:text-slate-200 text-sm font-medium">Remote / Worldwide</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-10 relative">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3">Find me on</p>
                                <div class="flex gap-2.5">
                                    <a href="#" class="w-9 h-9 rounded-lg bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-500 hover:text-brand-accent hover:-translate-y-1 transition-all text-sm">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="#" class="w-9 h-9 rounded-lg bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-500 hover:text-brand-accent hover:-translate-y-1 transition-all text-sm">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="#" class="w-9 h-9 rounded-lg bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-500 hover:text-brand-accent hover:-translate-y-1 transition-all text-sm">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Form -->
                        <div class="md:col-span-3 p-8 md:p-12 bg-white/40 dark:bg-slate-900/40">
                            <form class="space-y-5" onsubmit="event.preventDefault(); this.querySelector('button[type=submit]').textContent = '✓ Sent!'; ">
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div class="space-y-1.5">
                                        <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Name</label>
                                        <input type="text" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all placeholder-slate-300 dark:placeholder-slate-600" placeholder="Your name">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Email</label>
                                        <input type="email" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all placeholder-slate-300 dark:placeholder-slate-600" placeholder="you@company.com">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">What's this about?</label>
                                    <select class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-300 text-sm focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all cursor-pointer">
                                        <option>Project / Build</option>
                                        <option>Technical Consulting</option>
                                        <option>Job Opportunity</option>
                                        <option>Something else</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Message</label>
                                    <textarea class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all h-32 resize-none placeholder-slate-300 dark:placeholder-slate-600" placeholder="Tell me what you're building..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/20 hover:scale-[1.01] active:scale-[0.99] text-sm">
                                    Send message →
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="py-10 bg-slate-100 dark:bg-black/30 text-center border-t border-slate-200 dark:border-white/5">
            <div class="flex justify-center gap-5 mb-6">
                <a href="#" class="text-slate-400 hover:text-brand-accent transition-colors text-lg"><i class="fab fa-github"></i></a>
                <a href="#" class="text-slate-400 hover:text-brand-accent transition-colors text-lg"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-slate-400 hover:text-brand-accent transition-colors text-lg"><i class="fab fa-twitter"></i></a>
            </div>
            <p class="text-slate-400 text-xs font-mono">
                &lt;Dev/&gt; © 2024 — built from scratch, no templates
            </p>
        </footer>
    </div>

    <!-- ════════════════════════════════════════
         PROJECTS VIEW
    ════════════════════════════════════════ -->
    <div id="projects-view" class="hidden min-h-screen pt-28 pb-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start mb-12 gap-4">
                <div>
                    <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// archive</span>
                    <h1 class="text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-2">All Projects</h1>
                    <p class="text-slate-500 dark:text-slate-400">Everything I've shipped — or nearly shipped.</p>
                </div>
                <button onclick="switchView('home')" class="mt-2 px-5 py-2 rounded-lg border border-slate-200 dark:border-white/10 hover:bg-slate-100 dark:hover:bg-white/8 text-slate-700 dark:text-white text-sm transition-colors">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back
                </button>
            </div>

            <!-- Filters -->
            <div class="flex gap-2 overflow-x-auto pb-4 mb-8">
                <span class="px-4 py-1.5 rounded-full bg-brand-accent text-white text-xs font-semibold cursor-pointer">All</span>
                <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors">AI & Agents</span>
                <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors">Laravel</span>
                <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors">Python</span>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass-card rounded-xl overflow-hidden group">
                    <div class="h-44 relative overflow-hidden"><img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="chip bg-violet-500/10 text-violet-600 dark:text-violet-400 border border-violet-500/20">MCP SERVER</span>
                            <span class="chip bg-teal-500/10 text-teal-600 dark:text-teal-400 border border-teal-500/20">FASTAPI</span>
                        </div>
                        <h3 class="text-base font-display font-bold text-slate-900 dark:text-white mb-1 group-hover:text-brand-accent transition-colors">SQL AI Agent</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Safe database querying via MCP protocol.</p>
                    </div>
                </div>

                <div class="glass-card rounded-xl overflow-hidden group">
                    <div class="h-44 relative overflow-hidden"><img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="chip bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20">LARAVEL</span>
                            <span class="chip bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20">REACT</span>
                        </div>
                        <h3 class="text-base font-display font-bold text-slate-900 dark:text-white mb-1 group-hover:text-brand-accent transition-colors">SaaS CRM</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Enterprise CRM with subscription billing.</p>
                    </div>
                </div>

                <div class="glass-card rounded-xl overflow-hidden group">
                    <div class="h-44 relative overflow-hidden"><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="chip bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20">LANGCHAIN</span>
                            <span class="chip bg-green-600/10 text-green-600 dark:text-green-400 border border-green-600/20">PYTHON</span>
                        </div>
                        <h3 class="text-base font-display font-bold text-slate-900 dark:text-white mb-1 group-hover:text-brand-accent transition-colors">RAG Pipeline</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Document analysis with local LLMs.</p>
                    </div>
                </div>

                <div class="glass-card rounded-xl overflow-hidden group">
                    <div class="h-44 relative overflow-hidden"><img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="chip bg-pink-500/10 text-pink-500 dark:text-pink-400 border border-pink-500/20">LIVEWIRE</span>
                            <span class="chip bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20">LARAVEL</span>
                        </div>
                        <h3 class="text-base font-display font-bold text-slate-900 dark:text-white mb-1 group-hover:text-brand-accent transition-colors">Booking Engine</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Reactive appointment scheduling.</p>
                    </div>
                </div>

                <div class="glass-card rounded-xl overflow-hidden group">
                    <div class="h-44 bg-slate-200 dark:bg-slate-800 flex items-center justify-center">
                        <span class="text-slate-400 font-mono text-sm">e-learning</span>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="chip bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">VUE.JS</span>
                            <span class="chip bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 border border-yellow-500/20">FIREBASE</span>
                        </div>
                        <h3 class="text-base font-display font-bold text-slate-900 dark:text-white mb-1 group-hover:text-brand-accent transition-colors">LMS Platform</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Interactive student learning portal.</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="https://github.com" target="_blank" class="inline-flex items-center gap-2 text-slate-500 hover:text-brand-accent transition-colors text-sm">
                    <i class="fab fa-github"></i> More on GitHub
                </a>
            </div>
        </div>
    </div>

    <!-- AI Chat Widget (UI Only - Ready for RAG) -->
    <div id="ai-chat-widget" class="fixed bottom-6 right-6 z-[60] font-sans select-none">
        <!-- Chat window -->
        <div id="chat-window" class="chat-closed flex flex-col mb-3 w-[320px] bg-white dark:bg-[#0e1628] border border-slate-200 dark:border-white/8 rounded-2xl shadow-2xl overflow-hidden" style="height:380px;">
            <!-- Header -->
            <div class="flex-none bg-gradient-to-r from-blue-600 to-violet-600 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2.5 text-white">
                    <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-robot text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold leading-none">Portfolio Agent</p>
                        <p class="text-[10px] opacity-70 mt-0.5">RAG Backend Pending</p>
                    </div>
                </div>
                <button onclick="toggleChat()" class="w-6 h-6 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <i class="fas fa-times text-[10px]"></i>
                </button>
            </div>

            <!-- Messages -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-slate-50 dark:bg-slate-950/60" style="overscroll-behavior:contain;">
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-600 to-violet-600 flex-shrink-0 flex items-center justify-center mt-0.5">
                        <i class="fas fa-robot text-[9px] text-white"></i>
                    </div>
                    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-white/5 rounded-2xl rounded-tl-sm px-3 py-2.5 text-[13px] text-slate-600 dark:text-slate-300 shadow-sm max-w-[85%]">
                        Hey 👋 I'm ready to be hooked up to your RAG backend! Test the UI by sending a message below.
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="flex-none p-3 bg-white dark:bg-[#0e1628] border-t border-slate-100 dark:border-white/5">
                <form onsubmit="handleChatSubmit(event)" class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 rounded-full px-3 py-1.5 m-0">
                    <input type="text" id="chat-input" class="flex-1 bg-transparent text-[13px] text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none" placeholder="Type a message…" autocomplete="off">
                    <button type="submit" class="w-7 h-7 bg-brand-accent hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors flex-shrink-0">
                        <i class="fas fa-paper-plane text-[10px] text-white"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- FAB -->
        <button onclick="toggleChat()" id="chat-fab" aria-label="Open chat" class="w-14 h-14 bg-gradient-to-br from-blue-600 to-violet-600 rounded-full flex items-center justify-center text-white shadow-xl shadow-blue-500/30 hover:scale-110 active:scale-95 transition-transform duration-200 relative ml-auto">
            <span id="fab-ping" class="absolute inset-0 rounded-full bg-blue-500 animate-ping opacity-20"></span>
            <i id="fab-icon-open" class="fas fa-comment-dots text-xl"></i>
            <i id="fab-icon-close" class="fas fa-chevron-down text-lg hidden"></i>
        </button>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });

        // ── CHAT ──────────────────────────────────────────
        const chatWindow   = document.getElementById('chat-window');
        const chatMessages = document.getElementById('chat-messages');
        const fabIconOpen  = document.getElementById('fab-icon-open');
        const fabIconClose = document.getElementById('fab-icon-close');
        const fabPing      = document.getElementById('fab-ping');
        let isOpen = false;

        function toggleChat() {
            isOpen = !isOpen;
            if (isOpen) {
                chatWindow.classList.remove('chat-closed');
                chatWindow.classList.add('chat-open');
                fabIconOpen.classList.add('hidden');
                fabIconClose.classList.remove('hidden');
                if(fabPing) fabPing.classList.add('hidden');
                setTimeout(() => document.getElementById('chat-input').focus(), 260);
            } else {
                chatWindow.classList.remove('chat-open');
                chatWindow.classList.add('chat-closed');
                fabIconOpen.classList.remove('hidden');
                fabIconClose.classList.add('hidden');
            }
        }

        function addBubble(text, role) {
            const wrap = document.createElement('div');
            wrap.className = `flex gap-2 ${role === 'user' ? 'flex-row-reverse' : ''}`;

            if (role === 'ai') {
                const avatar = document.createElement('div');
                avatar.className = 'w-6 h-6 rounded-full bg-gradient-to-br from-blue-600 to-violet-600 flex-shrink-0 flex items-center justify-center mt-0.5';
                avatar.innerHTML = '<i class="fas fa-robot text-[9px] text-white"></i>';
                wrap.appendChild(avatar);
            }

            const bubble = document.createElement('div');
            bubble.className = role === 'user'
                ? 'bg-brand-accent text-white rounded-2xl rounded-tr-sm px-3 py-2.5 text-[13px] shadow-sm max-w-[82%]'
                : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-white/5 rounded-2xl rounded-tl-sm px-3 py-2.5 text-[13px] text-slate-600 dark:text-slate-300 shadow-sm max-w-[82%]';
            bubble.textContent = text;
            wrap.appendChild(bubble);
            chatMessages.appendChild(wrap);
            requestAnimationFrame(() => { chatMessages.scrollTop = chatMessages.scrollHeight; });
        }

        function handleChatSubmit(e) {
            if(e) e.preventDefault();
            const input = document.getElementById('chat-input');
            const msg   = input.value.trim();
            if (!msg) return;
            
            addBubble(msg, 'user');
            input.value = '';
            
            setTimeout(() => {
                addBubble("RAG Backend is offline. Please connect your API to process: '" + msg + "'", 'ai');
            }, 600);
        }

        // ── TYPING EFFECT ──────────────────────────────────
        const words = ['start_mcp_server()', 'php artisan migrate', 'python agent.py', 'npm run build'];
        let wi = 0;
        function typeWriter() {
            const el = document.getElementById('typing-text');
            if (!el) return;
            const word = words[wi];
            let j = 0, del = false;
            function tick() {
                el.textContent = word.substring(0, j);
                if (!del && j < word.length)      { j++; setTimeout(tick, 95); }
                else if (del && j > 0)             { j--; setTimeout(tick, 45); }
                else if (!del)                     { del = true; setTimeout(tick, 1600); }
                else { wi = (wi + 1) % words.length; setTimeout(typeWriter, 400); }
            }
            tick();
        }

        // ── VIEW SWITCHING ─────────────────────────────────
        function switchView(v) {
            document.getElementById('home-view').classList.toggle('hidden', v !== 'home');
            document.getElementById('projects-view').classList.toggle('hidden', v !== 'projects');
            window.scrollTo(0, 0);
        }

        // ── THEME ──────────────────────────────────────────
        function toggleTheme() {
            const h = document.documentElement;
            const isDark = h.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        // ── RATING ─────────────────────────────────────────
        function submitRating(n) {
            localStorage.setItem('user_rating', n);
            document.querySelectorAll('#user-rating-stars i').forEach(s => {
                const active = parseInt(s.dataset.value) <= n;
                s.classList.toggle('text-yellow-400', active);
                s.classList.toggle('text-slate-300', !active);
                s.classList.toggle('dark:text-slate-700', !active);
            });
            const lbl = document.getElementById('rating-label');
            if (lbl) {
                 lbl.textContent = '(129 reviews)';
                 lbl.classList.add('text-emerald-500', 'font-bold');
            }
            const thanks = document.getElementById('rating-thanks');
            if (thanks) {
                 thanks.classList.remove('hidden');
                 setTimeout(() => thanks.classList.add('hidden'), 2500);
            }
        }

        // ── NAVBAR SCROLL ──────────────────────────────────
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            const scrolled = window.scrollY > 20;
            nav.classList.toggle('bg-white/85', scrolled);
            nav.classList.toggle('dark:bg-slate-900/85', scrolled);
            nav.classList.toggle('backdrop-blur-md', scrolled);
            nav.classList.toggle('border-b', scrolled);
            nav.classList.toggle('border-slate-200', scrolled);
            nav.classList.toggle('dark:border-white/5', scrolled);
            nav.classList.toggle('shadow-sm', scrolled);
        });

        // ── INIT ───────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            typeWriter();
            const t = localStorage.getItem('theme');
            document.documentElement.classList.toggle('dark', t === 'dark');
            const r = localStorage.getItem('user_rating');
            if (r) submitRating(parseInt(r));
        });
    </script>
</body>
</html>