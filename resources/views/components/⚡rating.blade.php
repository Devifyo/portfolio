<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\PortfolioReview;

new class extends Component
{
    public int    $portfolioId  = 0;
    public string $step         = 'display'; // display | form | thanks
    public int    $selectedStar = 0;
    public string $name         = '';
    public string $feedback     = '';
    public bool   $alreadyRated = false;
    public float  $avg          = 0.0;
    public int    $total        = 0;
    public array  $allReviews   = [];
    public bool   $reviewsLoaded = false;
    public string $thankName    = '';

    public function mount(int $portfolioId): void
    {
        $this->portfolioId = $portfolioId;
        $this->refreshStats();
        $this->loadReviews();

        // Server-side duplicate check by IP
        $existing = PortfolioReview::where('portfolio_id', $portfolioId)
            ->where('ip_address', request()->ip())
            ->first();

        if ($existing) {
            $this->alreadyRated  = true;
            $this->selectedStar  = $existing->rating;
        }
    }

    private function refreshStats(): void
    {
        $q           = PortfolioReview::where('portfolio_id', $this->portfolioId);
        $this->total = (clone $q)->count();
        $this->avg   = $this->total > 0
            ? round((clone $q)->avg('rating'), 1)
            : 0.0;
    }

    public function selectStar(int $star): void
    {
        if ($this->alreadyRated || $star < 1 || $star > 5) return;
        $this->selectedStar = $star;
        $this->step         = 'form';
    }

    public function cancelForm(): void
    {
        $this->selectedStar = 0;
        $this->step         = 'display';
    }

    public function submitReview(): void
    {
        if ($this->alreadyRated) return;

        $this->validate([
            'name'         => ['required', 'string', 'min:2', 'max:100'],
            'feedback'     => ['nullable', 'string', 'max:2000'],
            'selectedStar' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $ip = request()->ip();

        // Final duplicate guard
        if (PortfolioReview::where('portfolio_id', $this->portfolioId)->where('ip_address', $ip)->exists()) {
            $this->alreadyRated = true;
            $this->step         = 'display';
            return;
        }

        // Geo lookup — single IP
        $country = $countryCode = $city = null;
        try {
            $geo = Http::timeout(3)
                ->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city")
                ->json();
            if (($geo['status'] ?? '') === 'success') {
                $country     = $geo['country']     ?? null;
                $countryCode = strtoupper($geo['countryCode'] ?? '');
                $city        = $geo['city']         ?? null;
            }
        } catch (\Throwable) {}

        PortfolioReview::create([
            'portfolio_id' => $this->portfolioId,
            'name'         => trim($this->name),
            'rating'       => $this->selectedStar,
            'feedback'     => trim($this->feedback) ?: null,
            'country'      => $country,
            'country_code' => $countryCode,
            'city'         => $city,
            'ip_address'   => $ip,
        ]);

        $this->thankName    = trim($this->name);
        $this->alreadyRated = true;
        $this->step         = 'thanks';
        $this->name         = '';
        $this->feedback     = '';
        $this->refreshStats();

        // Tell browser: save to localStorage so same device won't re-rate
        $this->dispatch('review-saved',
            portfolioId: $this->portfolioId,
            rating: $this->selectedStar
        );
    }

    public function loadReviews(): void
    {
        $flag = fn($code) => (!$code || strlen($code) !== 2) ? '' : implode('', array_map(
            fn($c) => mb_chr(0x1F1E6 + (ord(strtoupper($c)) - ord('A'))),
            str_split($code)
        ));

        $this->allReviews = PortfolioReview::where('portfolio_id', $this->portfolioId)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get()
            ->map(fn($r) => [
                'name'     => $r->name,
                'rating'   => $r->rating,
                'feedback' => $r->feedback ?? '',
                'location' => implode(', ', array_filter([$r->city, $r->country])),
                'flag'     => $flag($r->country_code),
                'ago'      => $r->created_at->diffForHumans(),
            ])
            ->toArray();

        $this->reviewsLoaded = true;
    }
};
?>

@php
$starLabel = ['', 'Poor', 'Fair', 'Good', 'Great', 'Excellent'];
$pid = $portfolioId;
@endphp

<style>[x-cloak]{display:none!important}</style>

<div
    data-aos="fade-up"
    data-aos-delay="150"
    x-data="{
        hover: 0,
        modalOpen: false,
        localRated: false,
        get rated() { return {{ $alreadyRated ? 'true' : 'false' }} || this.localRated; },
        init() {
            const saved = localStorage.getItem('folio_rev_{{ $pid }}');
            if (saved) this.localRated = true;
        }
    }"
    @review-saved.window="
        if ($event.detail.portfolioId === {{ $pid }}) {
            localStorage.setItem('folio_rev_{{ $pid }}', JSON.stringify({ rating: $event.detail.rating }));
            localRated = true;
        }
    "
>

    {{-- ══════════════════════════════════════════
         DISPLAY STATE
    ══════════════════════════════════════════ --}}
    @if($step === 'display')
    <div class="inline-flex flex-col gap-3">

        {{-- Aggregate row --}}
        <div class="flex items-center gap-4 py-3 px-4 rounded-2xl bg-white/60 dark:bg-slate-800/40 border border-slate-200 dark:border-white/8 shadow-sm w-fit">

            {{-- Stars filled to average --}}
            <div class="flex items-center gap-0.5">
                @for ($i = 1; $i <= 5; $i++)
                <i class="fas fa-star text-lg {{ $total > 0 && $i <= round($avg) ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600' }}"></i>
                @endfor
            </div>

            {{-- Score --}}
            <div class="border-l border-slate-200 dark:border-white/10 pl-4 pr-1">
                @if($total > 0)
                <div class="flex items-baseline gap-1">
                    <span class="font-display font-bold text-slate-900 dark:text-white text-sm leading-none">{{ $avg }}</span>
                    <span class="text-xs text-slate-400">/ 5</span>
                </div>
                <button @click="modalOpen = true"
                        class="text-xs text-brand-accent hover:underline font-medium mt-0.5 block text-left">
                    {{ $total }} {{ $total === 1 ? 'review' : 'reviews' }} →
                </button>
                @else
                <span class="text-xs text-slate-400">No reviews yet</span>
                @endif
            </div>
        </div>

        {{-- Interactive stars row --}}
        <div class="flex items-center gap-2">
            <div class="flex gap-1" x-data>
                @for ($i = 1; $i <= 5; $i++)
                <button type="button"
                        @if(!$alreadyRated)
                        @mouseover="if (!rated) hover = {{ $i }}"
                        @mouseleave="hover = 0"
                        wire:click="selectStar({{ $i }})"
                        @endif
                        :class="(hover >= {{ $i }} || {{ $selectedStar }} >= {{ $i }})
                            ? 'text-yellow-400 scale-110'
                            : 'text-slate-300 dark:text-slate-600'"
                        :title="rated ? '' : '{{ $starLabel[$i] }}'"
                        class="fas fa-star text-xl transition-all duration-100 {{ $alreadyRated ? 'cursor-default' : 'cursor-pointer hover:scale-110' }}">
                </button>
                @endfor
            </div>

            <span class="text-xs text-slate-400 dark:text-slate-500" x-show="!rated">
                <span x-show="hover === 0">{{ $alreadyRated ? '' : 'Tap to rate' }}</span>
                <span x-show="hover === 1" x-cloak>Poor</span>
                <span x-show="hover === 2" x-cloak>Fair</span>
                <span x-show="hover === 3" x-cloak>Good</span>
                <span x-show="hover === 4" x-cloak>Great</span>
                <span x-show="hover === 5" x-cloak>Excellent</span>
            </span>
            <span class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1" x-show="rated">
                <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                You reviewed this
            </span>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         FORM STATE
    ══════════════════════════════════════════ --}}
    @if($step === 'form')
    <div class="w-full max-w-sm rounded-2xl bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-white/10 shadow-xl p-5 backdrop-blur-sm"
         data-aos="fade-up">

        {{-- Selected stars + label --}}
        <div class="flex items-center gap-2 mb-4">
            <div class="flex gap-0.5">
                @for ($i = 1; $i <= 5; $i++)
                <button type="button" wire:click="selectStar({{ $i }})"
                        class="fas fa-star text-xl transition-colors cursor-pointer {{ $i <= $selectedStar ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600' }}">
                </button>
                @endfor
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                {{ $starLabel[$selectedStar] ?? '' }}
            </span>
        </div>

        <div class="space-y-3">
            {{-- Name --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                    Your name <span class="text-red-400">*</span>
                </label>
                <input wire:model="name" type="text"
                       placeholder="Alex Johnson"
                       autocomplete="name"
                       class="w-full text-sm px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:border-brand-accent transition-colors">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Feedback --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                    Feedback <span class="text-slate-400 font-normal">(optional)</span>
                </label>
                <textarea wire:model="feedback" rows="3"
                          placeholder="Share what you think about this portfolio…"
                          class="w-full text-sm px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:border-brand-accent transition-colors resize-none"></textarea>
                @error('feedback') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Geo notice --}}
            <p class="text-[11px] text-slate-400 flex items-center gap-1">
                <i class="fas fa-map-marker-alt text-[9px]"></i>
                Your approximate location will be noted from your IP address.
            </p>

            {{-- Buttons --}}
            <div class="flex items-center gap-2 pt-1">
                <button wire:click="submitReview" type="button"
                        class="flex-1 py-2.5 rounded-xl bg-brand-accent text-white text-sm font-bold hover:bg-blue-700 transition-colors shadow-sm shadow-brand-accent/20">
                    <span wire:loading.remove wire:target="submitReview">Submit Review</span>
                    <span wire:loading wire:target="submitReview" class="inline-flex items-center gap-1.5">
                        <i class="fas fa-circle-notch fa-spin text-xs"></i> Saving…
                    </span>
                </button>
                <button wire:click="cancelForm" type="button"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         THANKS STATE
    ══════════════════════════════════════════ --}}
    @if($step === 'thanks')
    <div class="flex items-start gap-3 py-3 px-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 shadow-sm w-fit max-w-sm"
         data-aos="fade-up">
        <div class="w-9 h-9 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <div>
            <p class="text-sm font-bold text-emerald-700 dark:text-emerald-400">
                Thanks, {{ $thankName }}!
            </p>
            <div class="flex gap-0.5 mt-1">
                @for ($i = 1; $i <= 5; $i++)
                <i class="fas fa-star text-sm {{ $i <= $selectedStar ? 'text-yellow-400' : 'text-slate-300' }}"></i>
                @endfor
            </div>
            <p class="text-xs text-emerald-600 dark:text-emerald-500 mt-1">Your review has been saved.</p>
        </div>
    </div>
    @endif


    {{-- ══════════════════════════════════════════
         ALL REVIEWS MODAL
    ══════════════════════════════════════════ --}}
    <div wire:ignore
         x-show="modalOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="modalOpen = false"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalOpen = false"></div>

        {{-- Panel --}}
        <div class="relative w-full max-w-xl max-h-[85vh] flex flex-col rounded-3xl bg-white dark:bg-[#0d1424] border border-slate-200 dark:border-white/10 shadow-2xl overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             @click.stop>

            {{-- Modal header --}}
            <div class="flex-none px-6 pt-6 pb-4 border-b border-slate-100 dark:border-white/8">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white">All Reviews</h2>
                    <button @click="modalOpen = false"
                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-white/20 transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                @if($total > 0)
                <div class="flex items-center gap-4">
                    <div>
                        <span class="text-4xl font-display font-bold text-slate-900 dark:text-white leading-none">{{ $avg }}</span>
                        <span class="text-slate-400 text-sm ml-1">/ 5</span>
                    </div>
                    <div>
                        <div class="flex gap-0.5 mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-base {{ $i <= round($avg) ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600' }}"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-slate-400">Based on {{ $total }} {{ $total === 1 ? 'review' : 'reviews' }}</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Reviews list --}}
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">

                @if(empty($allReviews))
                <div class="py-16 text-center">
                    <i class="fas fa-star text-4xl text-slate-200 dark:text-slate-700 mb-3 block"></i>
                    <p class="text-sm text-slate-400">No reviews yet. Be the first!</p>
                </div>
                @endif

                @foreach($allReviews as $r)
                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 p-4">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(mb_substr($r['name'], 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white leading-none">{{ $r['name'] }}</p>
                                @if($r['location'])
                                <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                    @if($r['flag'])<span>{{ $r['flag'] }}</span>@endif
                                    {{ $r['location'] }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <div class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $r['rating'] ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600' }}"></i>
                                @endfor
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $r['ago'] }}</span>
                        </div>
                    </div>
                    @if($r['feedback'])
                    <p class="text-[13px] text-slate-600 dark:text-slate-300 leading-relaxed mt-2 border-t border-slate-100 dark:border-white/5 pt-2">
                        "{{ $r['feedback'] }}"
                    </p>
                    @endif
                </div>
                @endforeach

            </div>

        </div>
    </div>

</div>
