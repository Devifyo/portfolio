<nav class="fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ url('/') }}" class="flex-shrink-0 cursor-pointer group relative z-50" wire:navigate>
                <span class="font-mono text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand-accent transition-colors">
                    &lt;Dev/<span class="text-brand-accent">_</span>&gt;
                </span>
            </a>

            <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center space-x-8">
                <a href="{{ url('/') }}#about" wire:navigate class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Stack</a>
                <a href="{{ url('/') }}#projects" wire:navigate class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Work</a>
                <a href="{{ url('/') }}#experience" wire:navigate class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Timeline</a>
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
                <a href="{{ url('/') }}#contact" wire:navigate class="px-5 py-2 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-80 transition-all shadow-md">
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
            <a href="{{ url('/') }}#about" wire:navigate class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Stack</a>
            <a href="{{ url('/') }}#projects" wire:navigate class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Work</a>
            <a href="{{ url('/') }}#experience" wire:navigate class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5">Timeline</a>
            <a href="{{ url('/') }}#contact" wire:navigate class="block px-3 py-3 rounded-lg text-base font-bold text-brand-accent">Hire Me</a>
        </div>
    </div>
</nav>