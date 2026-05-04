<section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
    <div class="absolute top-10 -left-20 w-[500px] h-[500px] bg-blue-500 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.08] dark:opacity-[0.12] animate-blob"></div>
    <div class="absolute top-20 -right-20 w-[400px] h-[400px] bg-violet-500 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.07] dark:opacity-[0.10] animate-blob" style="animation-delay:2.5s"></div>
    <div class="absolute -bottom-10 left-1/3 w-[350px] h-[350px] bg-cyan-400 rounded-full mix-blend-multiply filter blur-[140px] opacity-[0.06] dark:opacity-[0.08] animate-blob" style="animation-delay:5s"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-16 items-center">

        <div data-aos="fade-right" data-aos-duration="900">
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
                <a href="{{ url('/projects') }}" wire:navigate class="px-7 py-3.5 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-brand-dark text-sm font-bold hover:opacity-85 transition-all shadow-md flex items-center gap-2">
                    See my work <i class="fas fa-arrow-right text-xs"></i>
                </a>
                <a href="#contact" class="px-7 py-3.5 rounded-lg border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white text-sm font-medium hover:bg-slate-100 dark:hover:bg-white/8 transition-all">
                    Get in touch
                </a>
            </div>

            <livewire:rating />

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

        <div class="relative group" data-aos="fade-left" data-aos-duration="900" data-aos-delay="100">
            <div class="absolute -inset-1.5 bg-gradient-to-br from-blue-500 to-violet-600 rounded-2xl blur-lg opacity-20 group-hover:opacity-35 transition-all duration-700"></div>

            <div class="relative glass rounded-2xl overflow-hidden shadow-2xl">
                <div class="bg-slate-100 dark:bg-[#0d1117] px-4 py-3 flex items-center gap-3 border-b border-slate-200 dark:border-white/5">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    </div>
                    <div class="flex-1 text-center text-[11px] text-slate-400 font-mono">~/dev/agent_builder.py</div>
                </div>

                <div class="p-6 font-mono text-[13px] h-[340px] bg-[#fcfcfc] dark:bg-[#080d16] overflow-hidden relative">
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

@push('scripts')
<script>
    (function () {
        const words = ['start_mcp_server()', 'php artisan migrate', 'python agent.py', 'npm run build'];
        let wi = 0, running = false;
        function typeWriter() {
            const el = document.getElementById('typing-text');
            if (!el || running) return;
            running = true;
            const word = words[wi];
            let j = 0, del = false;
            function tick() {
                if (!document.getElementById('typing-text')) { running = false; return; }
                el.textContent = word.substring(0, j);
                if (!del && j < word.length)      { j++; setTimeout(tick, 95); }
                else if (del && j > 0)            { j--; setTimeout(tick, 45); }
                else if (!del)                    { del = true; setTimeout(tick, 1600); }
                else { wi = (wi + 1) % words.length; running = false; setTimeout(typeWriter, 400); }
            }
            tick();
        }
        document.addEventListener('DOMContentLoaded', typeWriter);
        document.addEventListener('livewire:navigated', typeWriter);
    })();
</script>
@endpush