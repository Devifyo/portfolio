<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Portfolio;

new #[Title('Create account — Folio')] #[Layout('layouts::auth')] class extends Component
{
    public string $name             = '';
    public string $username         = '';
    public string $email            = '';
    public string $password         = '';
    public string $password_confirm = '';
    public int    $step             = 1;

    public function mount(): void
    {
        if (auth()->check()) {
            redirect()->route('dashboard');
        }
    }

    public function updatedUsername(): void
    {
        $this->username = strtolower(preg_replace('/[^a-z0-9_\-]/i', '', $this->username));
    }

    public function register(): void
    {
        $this->validate([
            'name'             => ['required', 'string', 'max:100'],
            'username'         => ['required', 'string', 'min:3', 'max:30', 'regex:/^[a-z0-9_\-]+$/i', 'unique:users,username'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'min:8'],
            'password_confirm' => ['required', 'same:password'],
        ], [
            'username.regex'        => 'Letters, numbers, dashes and underscores only.',
            'username.unique'       => 'That username is already taken.',
            'email.unique'          => 'An account with that email already exists.',
            'password.min'          => 'Password must be at least 8 characters.',
            'password_confirm.same' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name'     => $this->name,
            'username' => strtolower($this->username),
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Portfolio::create([
            'user_id'    => $user->id,
            'hero_name'  => $this->name,
            'hero_title' => 'Full Stack Developer',
            'published'  => true,
        ]);

        Auth::login($user);
        redirect()->route('dashboard');
    }
};
?>

<div class="flex h-full min-h-screen">

    {{-- ================================================================
         LEFT PANEL — brand side
    ================================================================ --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[38%] flex-col relative bg-[#0a0f1e] overflow-hidden noise">

        <div class="absolute inset-0 dot-texture"></div>
        <div class="absolute -top-32 -right-20 w-72 h-72 bg-violet-600 rounded-full blur-[120px] opacity-[0.15]"></div>
        <div class="absolute bottom-0 -left-20 w-64 h-64 bg-brand-accent rounded-full blur-[100px] opacity-[0.10]"></div>

        <div class="relative flex flex-col h-full p-10 xl:p-14">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 self-start group">
                <div class="w-9 h-9 rounded-xl bg-brand-accent flex items-center justify-center shadow-lg shadow-brand-accent/40 group-hover:scale-95 transition-transform">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                <span class="font-display font-bold text-white text-lg">Folio</span>
            </a>

            {{-- Middle --}}
            <div class="flex-1 flex flex-col justify-center py-12">
                <p class="text-xs font-mono font-bold text-brand-accent tracking-[0.15em] uppercase mb-6">Free forever</p>
                <h2 class="font-display font-bold text-white text-4xl xl:text-5xl leading-[1.1] tracking-tight mb-6">
                    Your portfolio<br>
                    URL is waiting<br>
                    for you.
                </h2>
                <p class="text-slate-400 text-[0.9375rem] leading-relaxed max-w-[320px] mb-10">
                    Pick a username below and your portfolio goes live immediately — no design required.
                </p>

                {{-- Live URL preview --}}
                @if(strlen($username) >= 2)
                <div class="inline-flex items-center gap-2.5 px-4 py-3 rounded-xl border border-white/10 bg-white/5 self-start">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="font-mono text-sm text-slate-300">folio.app/u/<span class="text-emerald-400">{{ $username }}</span></span>
                </div>
                @else
                <div class="inline-flex items-center gap-2.5 px-4 py-3 rounded-xl border border-white/10 bg-white/5 self-start">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" class="text-slate-500"><path d="M7 1a6 6 0 100 12A6 6 0 007 1zm0 0v12M1 7h12" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>
                    <span class="font-mono text-sm text-slate-600">folio.app/u/<span class="text-slate-500">your-name</span></span>
                </div>
                @endif
            </div>

            {{-- Checklist --}}
            <div class="border-t border-white/8 pt-8 space-y-3">
                @foreach(['No design skills needed','Goes live instantly','Edit any time from your dashboard','100% free to get started'] as $item)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full border border-emerald-500/40 bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M1.5 5l2.5 2.5 4.5-4.5" stroke="#34d399" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span class="text-sm text-slate-400">{{ $item }}</span>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- ================================================================
         RIGHT PANEL — form side
    ================================================================ --}}
    <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1526]">

        {{-- Top bar --}}
        <div class="flex items-center justify-between px-8 py-6 lg:px-12">
            <a href="{{ url('/') }}" class="flex items-center gap-2 lg:hidden group">
                <div class="w-8 h-8 rounded-lg bg-brand-accent flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xs"></i>
                </div>
                <span class="font-display font-bold text-slate-900 dark:text-white text-base">Folio</span>
            </a>
            <div class="hidden lg:block"></div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-brand-accent font-semibold hover:underline ml-1">Log in</a>
            </p>
        </div>

        {{-- Centered form --}}
        <div class="flex-1 flex items-center justify-center px-8 py-8 lg:px-16 overflow-y-auto">
            <div class="w-full max-w-[420px]">

                <div class="mb-8">
                    <h1 class="font-display font-bold text-slate-900 dark:text-white text-3xl tracking-tight mb-2">
                        Create your portfolio.
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Free to start. Live in minutes.</p>
                </div>

                <form wire:submit="register" class="space-y-7">

                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">Full name</label>
                        <input wire:model="name" type="text" autocomplete="name"
                               placeholder="Alex Mercer"
                               class="input-line @error('name') error @enderror">
                        @error('name')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Username — the hero field --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">
                            Username <span class="text-slate-400 font-normal normal-case tracking-normal">— this becomes your URL</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-0 bottom-[0.75rem] text-slate-400 dark:text-slate-500 text-sm font-mono leading-none select-none">u/</span>
                            <input wire:model.live="username" type="text" autocomplete="off"
                                   placeholder="your-name"
                                   class="input-line pl-6 @error('username') error @enderror">
                        </div>
                        @error('username')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @elseif(strlen($username) >= 3)
                        <p class="mt-2 text-xs text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6l3 3 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Your portfolio will be live at <strong class="font-mono">/u/{{ $username }}</strong>
                        </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">Email</label>
                        <input wire:model="email" type="email" autocomplete="email"
                               placeholder="you@example.com"
                               class="input-line @error('email') error @enderror">
                        @error('email')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">Password</label>
                        <input wire:model="password" type="password" autocomplete="new-password"
                               placeholder="Min. 8 characters"
                               class="input-line @error('password') error @enderror">
                        @error('password')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Confirm password --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.1em] mb-2">Confirm password</label>
                        <input wire:model="password_confirm" type="password" autocomplete="new-password"
                               placeholder="Repeat your password"
                               class="input-line @error('password_confirm') error @enderror">
                        @error('password_confirm')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-1">
                        <button type="submit" class="btn-primary whitespace-nowrap">
                            <span wire:loading.remove wire:target="register">Create my portfolio →</span>
                            <span wire:loading wire:target="register" class="inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="32" stroke-dashoffset="12"/></svg>
                                Creating…
                            </span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <div class="px-8 py-5 lg:px-12">
            <p class="text-xs text-slate-400 dark:text-slate-600">
                By creating an account you agree to our <span class="underline cursor-pointer hover:text-slate-600 dark:hover:text-slate-400">Terms</span> and <span class="underline cursor-pointer hover:text-slate-600 dark:hover:text-slate-400">Privacy Policy</span>.
            </p>
        </div>

    </div>
</div>
