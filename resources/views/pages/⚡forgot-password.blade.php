<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;

new #[Title('Reset password — Folio')] #[Layout('layouts::auth')] class extends Component
{
    public string $email  = '';
    public bool   $sent   = false;

    public function mount(): void
    {
        if (auth()->check()) {
            redirect()->route('dashboard');
        }
    }

    public function send(): void
    {
        $this->validate(['email' => ['required', 'email']]);

        Password::sendResetLink(['email' => $this->email]);

        // Always show success to avoid email enumeration
        $this->sent  = true;
        $this->email = '';
    }
};
?>

<div class="flex h-full min-h-screen">

    {{-- ================================================================
         LEFT PANEL
    ================================================================ --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[38%] flex-col relative bg-[#0a0f1e] overflow-hidden noise">

        <div class="absolute inset-0 dot-texture"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-accent rounded-full blur-[130px] opacity-[0.12]"></div>

        <div class="relative flex flex-col h-full p-10 xl:p-14">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 self-start group">
                <div class="w-9 h-9 rounded-xl bg-brand-accent flex items-center justify-center shadow-lg shadow-brand-accent/40 group-hover:scale-95 transition-transform">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                <span class="font-display font-bold text-white text-lg">Folio</span>
            </a>

            <div class="flex-1 flex flex-col justify-center py-12">
                <p class="text-xs font-mono font-bold text-brand-accent tracking-[0.15em] uppercase mb-6">Account recovery</p>
                <h2 class="font-display font-bold text-white text-4xl xl:text-5xl leading-[1.1] tracking-tight mb-6">
                    We all forget<br>
                    passwords.
                </h2>
                <p class="text-slate-400 text-[0.9375rem] leading-relaxed max-w-[300px]">
                    Enter your email address and we'll send you a secure link to reset your password.
                </p>
            </div>

            <div class="border-t border-white/8 pt-8">
                <p class="text-slate-500 text-sm">Remembered it?
                    <a href="{{ route('login') }}" class="text-brand-accent hover:underline font-medium">Go back to login</a>
                </p>
            </div>

        </div>
    </div>

    {{-- ================================================================
         RIGHT PANEL
    ================================================================ --}}
    <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1526]">

        {{-- Top bar --}}
        <div class="flex items-center justify-between px-8 py-6 lg:px-12">
            <a href="{{ url('/') }}" class="flex items-center gap-2 lg:hidden">
                <div class="w-8 h-8 rounded-lg bg-brand-accent flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xs"></i>
                </div>
                <span class="font-display font-bold text-slate-900 dark:text-white text-base">Folio</span>
            </a>
            <div class="hidden lg:block"></div>
            <a href="{{ route('login') }}" class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M9 3L4 7l5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back to login
            </a>
        </div>

        {{-- Centered content --}}
        <div class="flex-1 flex items-center justify-center px-8 py-12 lg:px-16">
            <div class="w-full max-w-[400px]">

                @if(!$sent)

                <div class="mb-10">
                    {{-- Icon --}}
                    <div class="w-14 h-14 rounded-2xl bg-brand-accent/10 dark:bg-brand-accent/15 border border-brand-accent/20 flex items-center justify-center mb-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-brand-accent">
                            <rect x="2" y="6" width="20" height="13" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M2 9l10 6 10-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h1 class="font-display font-bold text-slate-900 dark:text-white text-3xl tracking-tight mb-2">
                        Forgot your password?
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        No problem. Enter your email and we'll send you a link to get back in.
                    </p>
                </div>

                <form wire:submit="send" class="space-y-8">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">Email address</label>
                        <input wire:model="email" type="email" autocomplete="email"
                               placeholder="you@example.com"
                               class="input-line @error('email') error @enderror">
                        @error('email')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary whitespace-nowrap">
                        <span wire:loading.remove wire:target="send">Send reset link</span>
                        <span wire:loading wire:target="send" class="inline-flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="32" stroke-dashoffset="12"/></svg>
                            Sending…
                        </span>
                    </button>
                </form>

                @else

                {{-- Success state --}}
                <div class="text-center py-8">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center mx-auto mb-6">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" class="text-emerald-500">
                            <path d="M5 14l6 6L23 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-slate-900 dark:text-white text-2xl tracking-tight mb-3">Check your inbox</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-[320px] mx-auto mb-8">
                        If an account exists with that email, you'll receive a password reset link shortly. Check your spam folder too.
                    </p>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-brand-accent hover:underline">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M9 3L4 7l5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Back to login
                    </a>
                </div>

                @endif

            </div>
        </div>

    </div>
</div>
