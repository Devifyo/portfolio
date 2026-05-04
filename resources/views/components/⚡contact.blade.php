<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use App\Mail\ContactFormMail;
use App\Models\Portfolio;

new class extends Component
{
    public int $portfolioId = 0;

    #[Validate('required|string|min:2|max:120')]
    public string $name = '';

    #[Validate('required|email|max:180')]
    public string $email = '';

    #[Validate('required|string')]
    public string $topic = 'Project / Build';

    #[Validate('required|string|min:10|max:4000')]
    public string $message = '';

    public bool   $sent  = false;
    public string $error = '';

    public array $topics = [
        'Project / Build',
        'Technical Consulting',
        'Job Opportunity',
        'Freelance Work',
        'Something else',
    ];

    public function mount(Portfolio $portfolio): void
    {
        $this->portfolioId = $portfolio->id;
    }

    public function submit(): void
    {
        $this->error = '';
        $this->validate();

        // Rate-limit: 3 submissions per IP per hour
        $key = 'contact:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->error = 'Too many messages sent. Please wait before trying again.';
            return;
        }
        RateLimiter::hit($key, 3600);

        $portfolio = Portfolio::with('user')->find($this->portfolioId);

        if (!$portfolio || !$portfolio->contact_email) {
            $this->error = 'Unable to send message. No contact email configured.';
            return;
        }

        try {
            Mail::to($portfolio->contact_email)
                ->send(new ContactFormMail(
                    portfolioOwnerName: $portfolio->hero_name ?: ($portfolio->user->name ?? 'there'),
                    portfolioUrl:       url('/u/' . $portfolio->user->username),
                    senderName:        $this->name,
                    senderEmail:       $this->email,
                    topic:             $this->topic,
                    userMessage:       $this->message,
                ));

            $this->reset(['name', 'email', 'message']);
            $this->topic = 'Project / Build';
            $this->sent  = true;
        } catch (\Throwable $e) {
            $this->error = 'Failed to send your message. Please try again later.';
            logger()->error('ContactFormMail failed', ['error' => $e->getMessage()]);
        }
    }
};
?>

<section id="contact" class="py-28 relative overflow-hidden">

    @php
    $portfolio = \App\Models\Portfolio::find($portfolioId);
    @endphp

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-brand-accent/8 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- Section label --}}
        <div class="mb-12 text-center" data-aos="fade-up">
            <span class="text-brand-accent font-bold tracking-wider uppercase text-sm font-mono">// contact</span>
            <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 dark:text-white mt-3">
                Got something interesting?<br>
                <span class="text-gradient">Let's talk.</span>
            </h2>
        </div>

        <div class="glass rounded-3xl overflow-hidden shadow-2xl" data-aos="fade-up" data-aos-delay="80">
            <div class="grid md:grid-cols-5">

                {{-- ── LEFT: Info panel ── --}}
                <div class="md:col-span-2 bg-slate-50 dark:bg-white/[0.03] p-10 flex flex-col justify-between relative overflow-hidden border-r border-slate-200 dark:border-white/5">
                    <div class="absolute -top-20 -right-20 w-56 h-56 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-20 -left-20 w-56 h-56 bg-violet-400/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative space-y-7">

                        {{-- Available for work badge --}}
                        @if($portfolio?->hero_available)
                        <div class="inline-flex items-center gap-2 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-full px-3.5 py-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                            <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">Available for work</span>
                        </div>
                        @endif

                        @if($portfolio?->contact_email)
                        <div class="flex items-start gap-4 group">
                            <div class="w-11 h-11 rounded-xl bg-white dark:bg-slate-800/80 shadow-sm flex items-center justify-center text-brand-accent flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1">Email</p>
                                <a href="mailto:{{ $portfolio->contact_email }}"
                                   class="text-slate-700 dark:text-slate-200 text-sm font-medium hover:text-brand-accent transition-colors break-all">
                                    {{ $portfolio->contact_email }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($portfolio?->contact_phone)
                        <div class="flex items-start gap-4 group">
                            <div class="w-11 h-11 rounded-xl bg-white dark:bg-slate-800/80 shadow-sm flex items-center justify-center text-sky-500 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-phone text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1">Phone</p>
                                <a href="tel:{{ $portfolio->contact_phone }}"
                                   class="text-slate-700 dark:text-slate-200 text-sm font-medium hover:text-brand-accent transition-colors">
                                    {{ $portfolio->contact_phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($portfolio?->contact_location)
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-white dark:bg-slate-800/80 shadow-sm flex items-center justify-center text-violet-500 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1">Location</p>
                                <p class="text-slate-700 dark:text-slate-200 text-sm font-medium">{{ $portfolio->contact_location }}</p>
                            </div>
                        </div>
                        @endif

                        @if($portfolio?->contact_calendly)
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-white dark:bg-slate-800/80 shadow-sm flex items-center justify-center text-emerald-500 flex-shrink-0">
                                <i class="fas fa-calendar-check text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1">Schedule a call</p>
                                <a href="{{ $portfolio->contact_calendly }}" target="_blank"
                                   class="text-slate-700 dark:text-slate-200 text-sm font-medium hover:text-brand-accent transition-colors inline-flex items-center gap-1">
                                    Book a slot <i class="fas fa-external-link-alt text-[9px]"></i>
                                </a>
                            </div>
                        </div>
                        @endif

                    </div>

                    {{-- Social + Hire links --}}
                    @php
                        $hasSocial   = $portfolio?->hero_github || $portfolio?->hero_linkedin;
                        $hasHireLinks = $portfolio?->contact_upwork || $portfolio?->contact_fiverr || $portfolio?->contact_freelancer;
                    @endphp

                    @if($hasSocial || $hasHireLinks)
                    <div class="mt-10 relative space-y-5">

                        @if($hasSocial)
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3">Find me on</p>
                            <div class="flex gap-2.5">
                                @if($portfolio->hero_github)
                                <a href="{{ $portfolio->hero_github }}" target="_blank"
                                   class="w-9 h-9 rounded-lg bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-500 hover:text-brand-accent hover:-translate-y-1 transition-all text-sm">
                                    <i class="fab fa-github"></i>
                                </a>
                                @endif
                                @if($portfolio->hero_linkedin)
                                <a href="{{ $portfolio->hero_linkedin }}" target="_blank"
                                   class="w-9 h-9 rounded-lg bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-500 hover:text-brand-accent hover:-translate-y-1 transition-all text-sm">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($hasHireLinks)
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3">Hire me on</p>
                            <div class="flex flex-col gap-2">
                                @if($portfolio->contact_upwork)
                                <a href="{{ $portfolio->contact_upwork }}" target="_blank"
                                   class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-lg bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-200 text-xs font-semibold hover:-translate-y-0.5 transition-all">
                                    <img src="https://cdn.simpleicons.org/upwork/6FDA44" class="w-4 h-4 flex-shrink-0" alt=""> Upwork
                                    <i class="fas fa-external-link-alt text-[8px] ml-auto text-slate-400"></i>
                                </a>
                                @endif
                                @if($portfolio->contact_fiverr)
                                <a href="{{ $portfolio->contact_fiverr }}" target="_blank"
                                   class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-lg bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-200 text-xs font-semibold hover:-translate-y-0.5 transition-all">
                                    <img src="https://cdn.simpleicons.org/fiverr/1DBF73" class="w-4 h-4 flex-shrink-0" alt=""> Fiverr
                                    <i class="fas fa-external-link-alt text-[8px] ml-auto text-slate-400"></i>
                                </a>
                                @endif
                                @if($portfolio->contact_freelancer)
                                <a href="{{ $portfolio->contact_freelancer }}" target="_blank"
                                   class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-lg bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-200 text-xs font-semibold hover:-translate-y-0.5 transition-all">
                                    <img src="https://cdn.simpleicons.org/freelancer/29B2FE" class="w-4 h-4 flex-shrink-0" alt=""> Freelancer
                                    <i class="fas fa-external-link-alt text-[8px] ml-auto text-slate-400"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                    @endif
                </div>

                {{-- ── RIGHT: Form ── --}}
                <div class="md:col-span-3 p-8 md:p-12 bg-white/40 dark:bg-slate-900/40">

                    @if($sent)
                    {{-- Success state --}}
                    <div class="h-full flex flex-col items-center justify-center text-center py-8" data-aos="fade-up">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center mx-auto mb-5">
                            <i class="fas fa-check text-emerald-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-display font-bold text-slate-900 dark:text-white mb-2">Message sent!</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xs">
                            Thanks for reaching out. You'll hear back soon.
                        </p>
                        <button wire:click="$set('sent', false)"
                                class="mt-6 text-sm text-brand-accent font-semibold hover:underline">
                            Send another message
                        </button>
                    </div>
                    @else
                    <form wire:submit.prevent="submit" class="space-y-5">

                        {{-- Name + Email --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Your name</label>
                                <input type="text" wire:model="name"
                                       class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all placeholder-slate-300 dark:placeholder-slate-600"
                                       placeholder="Alex Mercer">
                                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Your email</label>
                                <input type="email" wire:model="email"
                                       class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all placeholder-slate-300 dark:placeholder-slate-600"
                                       placeholder="you@company.com">
                                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Topic --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">What's this about?</label>
                            <select wire:model="topic"
                                    class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-300 text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all cursor-pointer">
                                @foreach($topics as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Message --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Message</label>
                            <textarea wire:model="message" rows="5"
                                      class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all resize-none placeholder-slate-300 dark:placeholder-slate-600"
                                      placeholder="Tell me what you're building..."></textarea>
                            @error('message')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Error alert --}}
                        @if($error)
                        <div class="rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 text-sm px-4 py-3 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                            {{ $error }}
                        </div>
                        @endif

                        {{-- Submit --}}
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="w-full bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/20 hover:scale-[1.01] active:scale-[0.99] text-sm disabled:opacity-60 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="submit">
                                Send message <i class="fas fa-arrow-right text-xs ml-1"></i>
                            </span>
                            <span wire:loading wire:target="submit" class="inline-flex items-center justify-center gap-2">
                                <i class="fas fa-circle-notch fa-spin text-xs"></i> Sending…
                            </span>
                        </button>

                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
