<div class="min-h-screen pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start mb-12 gap-4">
            <div>
                <span class="text-brand-accent text-sm font-mono font-bold tracking-widest uppercase">// archive</span>
                <h1 class="text-4xl font-display font-bold text-slate-900 dark:text-white mt-3 mb-2">All Projects</h1>
                <p class="text-slate-500 dark:text-slate-400">Everything I've shipped — or nearly shipped.</p>
            </div>
            <a href="{{ url('/') }}" wire:navigate class="mt-2 px-5 py-2 rounded-lg border border-slate-200 dark:border-white/10 hover:bg-slate-100 dark:hover:bg-white/8 text-slate-700 dark:text-white text-sm transition-colors">
                <i class="fas fa-arrow-left mr-2 text-xs"></i> Back
            </a>
        </div>

        <div class="flex gap-2 overflow-x-auto pb-4 mb-8">
            <span class="px-4 py-1.5 rounded-full bg-brand-accent text-white text-xs font-semibold cursor-pointer">All</span>
            <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors">AI & Agents</span>
            <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors">Laravel</span>
            <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors">Python</span>
        </div>

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
