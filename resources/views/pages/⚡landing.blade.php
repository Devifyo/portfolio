<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Title('Folio — Your portfolio, live today')] #[Layout('layouts::saas')] class extends Component
{
    public function mount(): void
    {
        if (auth()->check()) {
            redirect()->route('dashboard');
        }
    }
};
?>

<div>

{{-- ================================================================
     HERO
================================================================ --}}
<section class="relative min-h-screen flex flex-col">

    {{-- Fine dot grid — one subtle background element, nothing else --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background-image:radial-gradient(rgba(37,99,235,0.10) 1px,transparent 1px);background-size:28px 28px;mask-image:radial-gradient(ellipse 80% 70% at 50% 40%,black 40%,transparent 100%);-webkit-mask-image:radial-gradient(ellipse 80% 70% at 50% 40%,black 40%,transparent 100%)"></div>

    <div class="relative flex-1 flex items-center max-w-7xl mx-auto w-full px-6 lg:px-12 pt-8 pb-20">
        <div class="grid lg:grid-cols-[1fr_440px] gap-16 xl:gap-24 items-center w-full">

            {{-- Left: copy --}}
            <div>
                {{-- Eyebrow label --}}
                <div class="inline-flex items-center gap-2 mb-10">
                    <span class="block w-6 h-px bg-brand-accent"></span>
                    <span class="text-xs font-mono font-bold text-brand-accent tracking-[0.15em] uppercase">Developer portfolios</span>
                </div>

                {{-- Headline: each line has intentional weight --}}
                <h1 class="font-display font-bold text-slate-900 dark:text-white leading-[1.04] tracking-tight mb-8">
                    <span class="block text-[clamp(48px,6.5vw,88px)]">Your work.</span>
                    <span class="block text-[clamp(48px,6.5vw,88px)]">Your story.</span>
                    <span class="block text-[clamp(48px,6.5vw,88px)]"
                          style="background:linear-gradient(135deg,#2563eb,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                        Your link.
                    </span>
                </h1>

                <p class="text-[1.125rem] text-slate-500 dark:text-slate-400 leading-relaxed max-w-[480px] mb-10">
                    Fill in your details once. Get a polished, shareable portfolio at your own URL — no design skills, no hosting, no nonsense.
                </p>

                {{-- CTAs --}}
                <div class="flex items-center gap-4 flex-wrap mb-14">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-[10px] bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-85 transition-opacity shadow-lg">
                        Get started free
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        Already have an account
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M1.5 6h9M7 2.5l3.5 3.5L7 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                {{-- Social proof — numbers only, no avatars --}}
                <div class="flex items-center gap-6 pt-6 border-t border-slate-200 dark:border-white/10">
                    <div>
                        <p class="text-2xl font-display font-bold text-slate-900 dark:text-white">500+</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Portfolios live</p>
                    </div>
                    <div class="w-px h-8 bg-slate-200 dark:bg-white/10"></div>
                    <div>
                        <p class="text-2xl font-display font-bold text-slate-900 dark:text-white">&lt; 5 min</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Average setup time</p>
                    </div>
                    <div class="w-px h-8 bg-slate-200 dark:bg-white/10"></div>
                    <div>
                        <p class="text-2xl font-display font-bold text-slate-900 dark:text-white">Free</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Always, for core features</p>
                    </div>
                </div>
            </div>

            {{-- Right: product preview card --}}
            <div class="hidden lg:block">
                <div class="relative">
                    {{-- Browser chrome --}}
                    <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 shadow-2xl shadow-slate-900/10 dark:shadow-black/40">
                        {{-- Browser bar --}}
                        <div class="flex items-center gap-3 px-4 py-3 bg-slate-100 dark:bg-slate-800 border-b border-slate-200 dark:border-white/10">
                            <div class="flex gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                            </div>
                            <div class="flex-1 flex items-center gap-2 bg-white dark:bg-slate-700 rounded-md px-3 py-1.5">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" class="text-slate-400"><path d="M6 1a5 5 0 100 10A5 5 0 006 1zm0 0v10M1 6h10M2.2 3A6.5 6.5 0 016 1.5M2.2 9A6.5 6.5 0 006 10.5" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>
                                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">folio.app/u/<span class="text-brand-accent font-semibold">alexchen</span></span>
                            </div>
                        </div>
                        {{-- Portfolio preview content --}}
                        <div class="bg-white dark:bg-[#0d1526] p-6 space-y-4">
                            {{-- Profile row --}}
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">A</div>
                                <div>
                                    <p class="font-display font-bold text-slate-900 dark:text-white text-sm">Alex Chen</p>
                                    <p class="text-xs text-brand-accent font-medium">Backend Engineer</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="relative flex h-1.5 w-1.5">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                        </span>
                                        <span class="text-[9px] font-medium text-slate-400 uppercase tracking-wider">Open to work</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Tech tags --}}
                            <div>
                                <p class="text-[9px] font-mono font-bold text-slate-400 uppercase tracking-widest mb-2">Stack</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(['Go','PostgreSQL','Docker','Redis','Kubernetes'] as $t)
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-medium border border-slate-200 dark:border-white/10">{{ $t }}</span>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Stats row --}}
                            <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-100 dark:border-white/5">
                                @foreach([['23+','Projects'],['6+','Years'],['12+','Startups']] as $s)
                                <div class="text-center py-2">
                                    <p class="font-display font-bold text-brand-accent text-base">{{ $s[0] }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase tracking-wider">{{ $s[1] }}</p>
                                </div>
                                @endforeach
                            </div>
                            {{-- Project card preview --}}
                            <div class="rounded-xl border border-slate-100 dark:border-white/8 p-4">
                                <p class="text-xs font-display font-bold text-slate-900 dark:text-white">Distributed Task Queue</p>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 leading-relaxed">High-throughput job processor handling 50k messages/sec with Redis Streams.</p>
                                <div class="flex gap-2 mt-3">
                                    <span class="text-[10px] text-brand-accent flex items-center gap-1 font-medium"><i class="fab fa-github text-slate-400"></i> GitHub</span>
                                    <span class="text-[10px] text-emerald-500 flex items-center gap-1 font-medium"><i class="fas fa-external-link-alt text-[8px]"></i> Live</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating "live now" badge --}}
                    <div class="absolute -bottom-4 -right-4 flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 rounded-full px-4 py-2 shadow-lg">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Live in minutes</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================================================================
     FEATURES — numbered list, not cards
================================================================ --}}
<section id="features" class="border-t border-slate-200 dark:border-white/8">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-200 dark:divide-white/8">

            @php
            $features = [
                ['n'=>'01','title'=>'Instant setup','body'=>'Pick a username, fill in your info, and your portfolio is live. No templates to wrestle with, no deploy buttons to click.'],
                ['n'=>'02','title'=>'Always editable','body'=>'Change jobs, add a project, update your bio — edits go live the moment you save. Your portfolio grows as you do.'],
                ['n'=>'03','title'=>'One link, everywhere','body'=>'folio.app/u/you. Put it in your email signature, LinkedIn bio, or GitHub profile. One URL that never goes stale.'],
            ];
            @endphp

            @foreach($features as $i => $f)
            <div class="py-12 px-8 group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors duration-200">
                <span class="font-mono text-[11px] font-bold text-brand-accent tracking-[0.15em] block mb-5">{{ $f['n'] }}</span>
                <h3 class="font-display font-bold text-slate-900 dark:text-white text-xl mb-3">{{ $f['title'] }}</h3>
                <p class="text-[0.9375rem] text-slate-500 dark:text-slate-400 leading-relaxed">{{ $f['body'] }}</p>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ================================================================
     HOW IT WORKS — clean steps, no icons overload
================================================================ --}}
<section id="how-it-works" class="py-28 bg-slate-50/50 dark:bg-white/[0.015] border-t border-slate-200 dark:border-white/8">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

        <div class="max-w-xl mb-16">
            <span class="text-xs font-mono font-bold text-brand-accent tracking-[0.15em] uppercase block mb-4">How it works</span>
            <h2 class="font-display font-bold text-slate-900 dark:text-white text-4xl md:text-5xl leading-[1.08] tracking-tight">
                Three steps.<br>Five minutes.
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $steps = [
                ['step'=>'Step 1','title'=>'Create your account','body'=>'Choose a username — it becomes your permanent portfolio URL. Takes under 30 seconds.','detail'=>'No credit card. No commitments.'],
                ['step'=>'Step 2','title'=>'Fill in your story','body'=>'Add your bio, tech stack, work history, and projects. Dashboard is clean, no learning curve.','detail'=>'Edits are instant.'],
                ['step'=>'Step 3','title'=>'Share your link','body'=>'Send folio.app/u/you to every recruiter, client, and conference. One link to rule them all.','detail'=>'Always up to date.'],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="relative pl-8 border-l-2 border-slate-200 dark:border-white/10
                        {{ $i === 0 ? 'border-brand-accent' : '' }}">
                <span class="text-[11px] font-mono font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest block mb-3">{{ $step['step'] }}</span>
                <h3 class="font-display font-bold text-slate-900 dark:text-white text-xl mb-3">{{ $step['title'] }}</h3>
                <p class="text-[0.9375rem] text-slate-500 dark:text-slate-400 leading-relaxed mb-4">{{ $step['body'] }}</p>
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6l3 3 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ $step['detail'] }}
                </span>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ================================================================
     TESTIMONIALS — minimal, editorial
================================================================ --}}
<section class="py-28 border-t border-slate-200 dark:border-white/8">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid md:grid-cols-3 gap-10">
            @php
            $testimonials = [
                ['body'=>'I sent my Folio link to three companies. Two called back within a week. The portfolio speaks for itself.','name'=>'Jamie L.','role'=>'Frontend Engineer'],
                ['body'=>'Finally stopped saying "I need to update my portfolio." Took 8 minutes, looks better than anything I\'d have built myself.','name'=>'Ravi S.','role'=>'Fullstack Developer'],
                ['body'=>'My GitHub is messy and my PDF resume is boring. This sits in the middle and it\'s exactly what I needed.','name'=>'Priya M.','role'=>'Backend Engineer'],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="flex flex-col gap-5">
                {{-- Star rating --}}
                <div class="flex gap-1">
                    @for($i = 0; $i < 5; $i++)
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="#fbbf24"><path d="M7 1l1.545 3.13L12 4.635l-2.5 2.435.59 3.43L7 8.865l-3.09 1.635.59-3.43L2 4.635l3.455-.505L7 1z"/></svg>
                    @endfor
                </div>
                <p class="text-[0.9375rem] text-slate-600 dark:text-slate-400 leading-relaxed flex-1">&ldquo;{{ $t['body'] }}&rdquo;</p>
                <div class="pt-4 border-t border-slate-200 dark:border-white/10">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $t['name'] }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $t['role'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================================================================
     FINAL CTA — full-width dark block
================================================================ --}}
<section class="bg-[#0a0f1e] dark:bg-white/[0.03] border-t border-white/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-24 flex flex-col md:flex-row md:items-center justify-between gap-10">
        <div>
            <h2 class="font-display font-bold text-white text-4xl md:text-5xl leading-[1.08] tracking-tight mb-4">
                Stop putting it off.
            </h2>
            <p class="text-slate-400 text-[1.0625rem] leading-relaxed max-w-md">
                Your work deserves a proper home. Set up your portfolio today — it takes less than five minutes and costs nothing.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2.5 px-8 py-4 rounded-[10px] bg-white text-slate-900 text-[0.9375rem] font-bold hover:opacity-88 transition-opacity shadow-2xl shadow-black/30">
                Build my portfolio now
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 8h12M9 3l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <p class="text-xs text-slate-500 mt-3 text-center">Free. No credit card required.</p>
        </div>
    </div>
</section>

{{-- ================================================================
     FOOTER
================================================================ --}}
<footer class="bg-[#0a0f1e] border-t border-white/5 py-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-md bg-brand-accent flex items-center justify-center">
                <i class="fas fa-bolt text-white text-[10px]"></i>
            </div>
            <span class="font-display font-bold text-white text-sm">Folio</span>
        </div>
        <p class="text-xs text-slate-600">© {{ date('Y') }} Folio. Built with Laravel &amp; Livewire.</p>
    </div>
</footer>

</div>
