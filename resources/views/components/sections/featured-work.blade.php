<section id="projects" class="py-28 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-14 gap-4">
            <div data-aos="fade-right">
                <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// work</span>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-2">A few highlights.</h2>
                <p class="text-slate-500 dark:text-slate-400">Where AI meets robust engineering.</p>
            </div>
            <a href="{{ url('/projects') }}" wire:navigate class="flex items-center gap-2 text-brand-accent text-sm font-semibold hover:opacity-75 transition-opacity">
                Full archive <i class="fas fa-arrow-right text-xs"></i>
            </a>
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
