<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

new #[Title('Log in — Folio')] #[Layout('layouts::auth')] class extends Component
{
    public string $email    = '';
    public string $password = '';
    public bool   $remember = false;

    public function mount(): void
    {
        if (auth()->check()) {
            redirect()->route(auth()->user()->is_admin ? 'admin' : 'dashboard');
        }
    }

    public function login(): void
    {
        $this->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        redirect()->route(auth()->user()->is_admin ? 'admin' : 'dashboard');
    }
};
?>

<div class="flex h-full min-h-screen">

    {{-- ================================================================
         LEFT PANEL — dark brand side
    ================================================================ --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[38%] flex-col relative bg-[#0a0f1e] overflow-hidden noise">

        {{-- Dot texture --}}
        <div class="absolute inset-0 dot-texture opacity-100"></div>

        {{-- Subtle accent glow in corner --}}
        <div class="absolute -top-32 -left-32 w-80 h-80 bg-brand-accent rounded-full blur-[120px] opacity-[0.15]"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-violet-600 rounded-full blur-[100px] opacity-[0.10]"></div>

        <div class="relative flex flex-col h-full p-10 xl:p-14">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 self-start group">
                <div class="w-9 h-9 rounded-xl bg-brand-accent flex items-center justify-center shadow-lg shadow-brand-accent/40 group-hover:scale-95 transition-transform">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                <span class="font-display font-bold text-white text-lg">Folio</span>
            </a>

            {{-- Middle content --}}
            <div class="flex-1 flex flex-col justify-center py-12">
                <p class="text-xs font-mono font-bold text-brand-accent tracking-[0.15em] uppercase mb-6">
                    Developer portfolios
                </p>
                <h2 class="font-display font-bold text-white text-4xl xl:text-5xl leading-[1.1] tracking-tight mb-6">
                    One link.<br>
                    Every<br>
                    opportunity.
                </h2>
                <p class="text-slate-400 text-[0.9375rem] leading-relaxed max-w-[320px]">
                    Hundreds of developers use Folio to land jobs, win clients, and build in public — with a single shareable URL.
                </p>

                {{-- Decorative portfolio URL --}}
                <div class="mt-10 inline-flex items-center gap-2.5 px-4 py-3 rounded-xl border border-white/10 bg-white/5 self-start">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" class="text-slate-400"><path d="M7 1a6 6 0 100 12A6 6 0 007 1zm0 0v12M1 7h12M2.5 3.5A8 8 0 017 2M2.5 10.5A8 8 0 007 12" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>
                    <span class="font-mono text-sm text-slate-300">folio.app/u/<span class="text-brand-accent">you</span></span>
                </div>
            </div>

            {{-- Testimonial --}}
            <div class="border-t border-white/8 pt-8">
                <p class="text-slate-400 text-sm leading-relaxed mb-5 italic">
                    &ldquo;I set it up on a Sunday afternoon. By Tuesday I had an interview. The recruiter said my portfolio stood out immediately.&rdquo;
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">K</div>
                    <div>
                        <p class="text-sm font-semibold text-white">Karan Mehta</p>
                        <p class="text-xs text-slate-500">Full Stack Developer</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================
         RIGHT PANEL — form side
    ================================================================ --}}
    <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1526]">

        {{-- Top bar --}}
        <div class="flex items-center justify-between px-8 py-6 lg:px-12">
            {{-- Mobile logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2 lg:hidden group">
                <div class="w-8 h-8 rounded-lg bg-brand-accent flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xs"></i>
                </div>
                <span class="font-display font-bold text-slate-900 dark:text-white text-base">Folio</span>
            </a>
            <div class="hidden lg:block"></div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                New here?
                <a href="{{ route('register') }}" class="text-brand-accent font-semibold hover:underline ml-1">Create an account</a>
            </p>
        </div>

        {{-- Centered form --}}
        <div class="flex-1 flex items-center justify-center px-8 py-12 lg:px-16">
            <div class="w-full max-w-[400px]">

                <div class="mb-10">
                    <h1 class="font-display font-bold text-slate-900 dark:text-white text-3xl tracking-tight mb-2">
                        Welcome back.
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Log in to update and share your portfolio.</p>
                </div>

                <form wire:submit="login" class="space-y-8">

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">Email</label>
                        <input wire:model="email" type="email" autocomplete="email"
                               placeholder="you@example.com"
                               class="input-line @error('email') error @enderror">
                        @error('email')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em]">Password</label>
                            <a href="{{ route('forgot-password') }}" class="text-xs text-brand-accent hover:underline">Forgot password?</a>
                        </div>
                        <input wire:model="password" type="password" autocomplete="current-password"
                               placeholder="••••••••"
                               class="input-line @error('password') error @enderror">
                        @error('password')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="$toggle('remember')"
                                class="relative w-10 h-5 rounded-full transition-colors duration-200 {{ $remember ? 'bg-brand-accent' : 'bg-slate-200 dark:bg-slate-700' }} flex-shrink-0">
                            <span class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform duration-200 {{ $remember ? 'translate-x-5' : '' }}"></span>
                        </button>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Stay signed in for 30 days</span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary whitespace-nowrap">
                        <span wire:loading.remove wire:target="login">Log in</span>
                        <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="32" stroke-dashoffset="12"/></svg>
                            Signing in…
                        </span>
                    </button>

                </form>

                {{-- Mobile signup link --}}
                <p class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400 lg:hidden">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-brand-accent font-semibold hover:underline">Get started free</a>
                </p>

            </div>
        </div>

        {{-- Bottom legal --}}
        <div class="px-8 py-5 lg:px-12">
            <p class="text-xs text-slate-400 dark:text-slate-600">
                By continuing, you agree to our <span class="underline cursor-pointer hover:text-slate-600 dark:hover:text-slate-400">Terms</span> and <span class="underline cursor-pointer hover:text-slate-600 dark:hover:text-slate-400">Privacy Policy</span>.
            </p>
        </div>

    </div>
</div>
