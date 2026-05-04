<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Js;
use App\Models\PortfolioView;
use App\Models\PortfolioReview;

new #[Title('Analytics — Folio')] #[Layout('layouts::saas')] class extends Component
{
    public array  $stats       = ['total' => 0, 'today' => 0, 'week' => 0, 'month' => 0];
    public array  $countries   = [];
    public array  $recent      = [];
    public array  $chartLabels = [];
    public array  $chartData   = [];
    public string $updatedAt   = '';
    public bool   $hasData     = false;

    // Reviews
    public array $reviews     = [];
    public float $reviewAvg   = 0.0;
    public int   $reviewTotal = 0;
    public array $reviewBreakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

    public function mount(): void
    {
        if (Auth::user()->is_admin) {
            redirect()->route('admin');
            return;
        }

        $this->compute();
    }

    public function refresh(): void
    {
        $this->compute();
        $this->dispatch('chart-update', labels: $this->chartLabels, data: $this->chartData);
    }

    private function compute(): void
    {
        $portfolio = Auth::user()->portfolio;
        if (!$portfolio) return;

        // Batch-resolve pending geolocations
        $unresolved = PortfolioView::where('portfolio_id', $portfolio->id)
            ->whereNull('country')
            ->whereNotNull('ip_address')
            ->limit(100)
            ->get(['id', 'ip_address']);

        if ($unresolved->isNotEmpty()) {
            try {
                $payload = $unresolved->map(fn($v) => ['query' => $v->ip_address])->toArray();
                $results = Http::timeout(4)
                    ->post('http://ip-api.com/batch?fields=status,country,countryCode,city,query', $payload)
                    ->json();

                if (is_array($results)) {
                    foreach ($results as $r) {
                        if (($r['status'] ?? '') === 'success') {
                            PortfolioView::where('portfolio_id', $portfolio->id)
                                ->where('ip_address', $r['query'])
                                ->whereNull('country')
                                ->update([
                                    'country'      => $r['country'] ?? null,
                                    'country_code' => strtoupper($r['countryCode'] ?? ''),
                                    'city'         => $r['city'] ?? null,
                                ]);
                        }
                    }
                }
            } catch (\Throwable) {}
        }

        $q = PortfolioView::where('portfolio_id', $portfolio->id);

        $this->stats = [
            'total' => (clone $q)->count(),
            'today' => (clone $q)->whereDate('created_at', today())->count(),
            'week'  => (clone $q)->where('created_at', '>=', now()->subDays(7))->count(),
            'month' => (clone $q)->where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // Daily chart — last 30 days
        $daily = (clone $q)
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as cnt')
            ->groupBy('date')
            ->pluck('cnt', 'date');

        $labels = [];
        $data   = [];
        for ($i = 29; $i >= 0; $i--) {
            $d        = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M j');
            $data[]   = (int) ($daily->get($d, 0));
        }
        $this->chartLabels = $labels;
        $this->chartData   = $data;

        // Top countries
        $this->countries = (clone $q)
            ->whereNotNull('country')
            ->selectRaw('country, country_code, COUNT(*) as cnt')
            ->groupBy('country', 'country_code')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get()
            ->map(fn($r) => ['name' => $r->country, 'code' => $r->country_code, 'cnt' => (int)$r->cnt])
            ->toArray();

        // Recent visitors
        $this->recent = (clone $q)
            ->orderByDesc('created_at')
            ->limit(15)
            ->get(['country', 'country_code', 'city', 'referer', 'created_at'])
            ->map(fn($r) => [
                'location' => implode(', ', array_filter([$r->city, $r->country])) ?: 'Unknown',
                'code'     => $r->country_code ?? '',
                'referer'  => $r->referer ? (parse_url($r->referer, PHP_URL_HOST) ?? 'Direct') : 'Direct',
                'ago'      => $r->created_at->diffForHumans(),
            ])
            ->toArray();

        $this->hasData   = $this->stats['total'] > 0;
        $this->updatedAt = now()->format('M j, g:i A');

        // Reviews
        $rq = PortfolioReview::where('portfolio_id', $portfolio->id);
        $this->reviewTotal = (clone $rq)->count();
        $this->reviewAvg   = $this->reviewTotal > 0
            ? round((clone $rq)->avg('rating'), 1)
            : 0.0;

        $breakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        if ($this->reviewTotal > 0) {
            (clone $rq)->selectRaw('rating, COUNT(*) as cnt')->groupBy('rating')
                ->get()->each(fn($r) => $breakdown[(int)$r->rating] = (int)$r->cnt);
        }
        $this->reviewBreakdown = $breakdown;

        $flagFn = fn($code) => (!$code || strlen($code) !== 2) ? '' : implode('', array_map(
            fn($c) => mb_chr(0x1F1E6 + (ord(strtoupper($c)) - ord('A'))),
            str_split($code)
        ));

        $this->reviews = (clone $rq)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get()
            ->map(fn($r) => [
                'name'     => $r->name,
                'rating'   => $r->rating,
                'feedback' => $r->feedback ?? '',
                'location' => implode(', ', array_filter([$r->city, $r->country])),
                'flag'     => $flagFn($r->country_code),
                'ago'      => $r->created_at->diffForHumans(),
            ])
            ->toArray();
    }
};
?>

@php
$flag = fn($code) => (!$code || strlen($code) !== 2) ? '🌐' : implode('', array_map(
    fn($c) => mb_chr(0x1F1E6 + (ord(strtoupper($c)) - ord('A'))),
    str_split($code)
));
$maxCnt = max(array_column($countries, 'cnt') ?: [1]);
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Page header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-brand-accent/10 dark:bg-brand-accent/20 flex items-center justify-center">
                    <i class="fas fa-chart-line text-brand-accent text-sm"></i>
                </div>
                Analytics
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Who's visiting your portfolio — and from where.
                @if($updatedAt)
                <span class="text-slate-400 dark:text-slate-500">· Updated {{ $updatedAt }}</span>
                @endif
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/u/' . auth()->user()->username) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl glass border border-slate-200 dark:border-white/10 text-sm font-medium text-slate-700 dark:text-slate-300 hover:border-brand-accent/40 transition-all">
                <i class="fas fa-external-link-alt text-xs text-brand-accent"></i>
                /u/{{ auth()->user()->username }}
            </a>
            <button wire:click="refresh"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-semibold hover:opacity-85 transition-all shadow-sm">
                <span wire:loading.remove wire:target="refresh">
                    <i class="fas fa-sync-alt text-xs mr-0.5"></i> Refresh
                </span>
                <span wire:loading wire:target="refresh" class="inline-flex items-center gap-1.5">
                    <i class="fas fa-circle-notch fa-spin text-xs"></i> Loading…
                </span>
            </button>
        </div>
    </div>

    @if(!auth()->user()->portfolio)
    <div class="glass-card rounded-2xl p-16 text-center">
        <i class="fas fa-chart-line text-4xl text-slate-300 dark:text-slate-600 mb-4 block"></i>
        <p class="text-slate-500 dark:text-slate-400">Set up your portfolio first to see analytics.</p>
        <a href="{{ route('dashboard') }}" class="mt-4 inline-flex items-center gap-2 text-brand-accent font-semibold text-sm hover:underline">
            Go to Dashboard <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
    @else

    @if(!$hasData)
    {{-- ── Zero state ── --}}
    <div class="glass-card rounded-2xl p-20 text-center">
        <div class="w-20 h-20 rounded-2xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-chart-line text-4xl text-blue-400 dark:text-blue-500"></i>
        </div>
        <h2 class="text-xl font-display font-bold text-slate-900 dark:text-white mb-2">No visitors yet</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 max-w-sm mx-auto">
            Share your portfolio link and come back here to see who's visiting.
        </p>
        <a href="{{ url('/u/' . auth()->user()->username) }}" target="_blank"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-accent text-white text-sm font-bold hover:bg-blue-700 transition-colors shadow-md shadow-brand-accent/20">
            <i class="fas fa-external-link-alt text-xs"></i>
            View My Portfolio
        </a>
    </div>
    @else

    {{-- ── Stat cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['label'=>'All Time',   'value'=>$stats['total'], 'icon'=>'fas fa-eye',          'color'=>'blue',    'sub'=>'total views'],
            ['label'=>'This Month', 'value'=>$stats['month'], 'icon'=>'fas fa-calendar-alt', 'color'=>'violet',  'sub'=>'last 30 days'],
            ['label'=>'This Week',  'value'=>$stats['week'],  'icon'=>'fas fa-calendar-week','color'=>'emerald', 'sub'=>'last 7 days'],
            ['label'=>'Today',      'value'=>$stats['today'], 'icon'=>'fas fa-sun',          'color'=>'amber',   'sub'=>date('M j')],
        ] as $c)
        @php
        $pal = [
            'blue'    => ['wrap'=>'bg-blue-50 dark:bg-blue-500/10',    'icon'=>'text-blue-500',    'num'=>'text-blue-600 dark:text-blue-400'],
            'violet'  => ['wrap'=>'bg-violet-50 dark:bg-violet-500/10','icon'=>'text-violet-500', 'num'=>'text-violet-600 dark:text-violet-400'],
            'emerald' => ['wrap'=>'bg-emerald-50 dark:bg-emerald-500/10','icon'=>'text-emerald-500','num'=>'text-emerald-600 dark:text-emerald-400'],
            'amber'   => ['wrap'=>'bg-amber-50 dark:bg-amber-500/10',  'icon'=>'text-amber-500',  'num'=>'text-amber-600 dark:text-amber-400'],
        ][$c['color']];
        @endphp
        <div class="glass-card rounded-2xl p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl {{ $pal['wrap'] }} flex items-center justify-center flex-shrink-0">
                    <i class="{{ $c['icon'] }} text-sm {{ $pal['icon'] }}"></i>
                </div>
                <span class="text-xs font-medium text-slate-400 dark:text-slate-500">{{ $c['label'] }}</span>
            </div>
            <div>
                <p class="text-4xl font-display font-bold {{ $pal['num'] }} leading-none">{{ number_format($c['value']) }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $c['sub'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Daily chart ── --}}
    <div class="glass-card rounded-2xl p-6 mb-6"
         x-data="{
             chart: null,
             init() {
                 this.$nextTick(() => this.initChart(
                     {!! Js::from($chartLabels) !!},
                     {!! Js::from($chartData) !!}
                 ));
             },
             initChart(labels, data) {
                 if (this.chart) this.chart.destroy();
                 this.chart = new Chart(this.$refs.canvas, {
                     type: 'line',
                     data: {
                         labels: labels,
                         datasets: [{
                             data: data,
                             borderColor: '#2563eb',
                             backgroundColor: 'rgba(37,99,235,0.07)',
                             fill: true,
                             tension: 0.4,
                             pointRadius: 3,
                             pointHoverRadius: 5,
                             pointBackgroundColor: '#2563eb',
                             borderWidth: 2,
                         }]
                     },
                     options: {
                         responsive: true,
                         maintainAspectRatio: true,
                         plugins: { legend: { display: false }, tooltip: { callbacks: {
                             label: ctx => ' ' + ctx.parsed.y + (ctx.parsed.y === 1 ? ' view' : ' views')
                         }}},
                         scales: {
                             x: { grid: { display: false }, ticks: { maxTicksLimit: 10, color: '#94a3b8', font: { size: 11 } } },
                             y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0, color: '#94a3b8', font: { size: 11 } }, grid: { color: 'rgba(148,163,184,0.1)' } }
                         }
                     }
                 });
             }
         }"
         @chart-update.window="initChart($event.detail.labels, $event.detail.data)"
         wire:ignore>
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-sm font-bold text-slate-800 dark:text-white">Daily views</h2>
                <p class="text-xs text-slate-400 mt-0.5">Last 30 days</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 text-xs font-bold">
                {{ number_format($stats['month']) }} this month
            </span>
        </div>
        <canvas x-ref="canvas" height="80"></canvas>
    </div>

    {{-- ── Countries + Recent ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Top Countries --}}
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-5">
                <span class="w-7 h-7 rounded-lg bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center">
                    <i class="fas fa-globe text-violet-500 text-xs"></i>
                </span>
                Top Countries
            </h2>
            @if(empty($countries))
            <div class="py-10 text-center">
                <p class="text-sm text-slate-400">Location data will appear after geo resolution.</p>
                <p class="text-xs text-slate-400 mt-1">Click Refresh to resolve pending locations.</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($countries as $country)
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl leading-none">{{ $flag($country['code']) }}</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $country['name'] }}</span>
                        </div>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 tabular-nums">
                            {{ $country['cnt'] }} {{ $country['cnt'] === 1 ? 'view' : 'views' }}
                        </span>
                    </div>
                    <div class="h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-violet-500 rounded-full"
                             style="width: {{ round($country['cnt'] / $maxCnt * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Recent Visitors --}}
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-5">
                <span class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                    <i class="fas fa-user-clock text-emerald-500 text-xs"></i>
                </span>
                Recent Visitors
            </h2>
            @if(empty($recent))
            <div class="py-10 text-center">
                <p class="text-sm text-slate-400">No visitors recorded yet.</p>
            </div>
            @else
            <div class="divide-y divide-slate-100 dark:divide-white/5">
                @foreach($recent as $v)
                <div class="flex items-center gap-3 py-2.5 first:pt-0 last:pb-0">
                    <span class="text-2xl leading-none flex-shrink-0 w-8 text-center">{{ $flag($v['code']) }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold text-slate-700 dark:text-slate-200 truncate">{{ $v['location'] }}</p>
                        <p class="text-[11px] text-slate-400 truncate flex items-center gap-1">
                            <i class="fas fa-arrow-right text-[9px]"></i>
                            {{ $v['referer'] }}
                        </p>
                    </div>
                    <span class="text-[11px] text-slate-400 flex-shrink-0 whitespace-nowrap">{{ $v['ago'] }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
    @endif

    {{-- ── Reviews section ── --}}
    <div class="mt-6">

        {{-- Section header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-yellow-50 dark:bg-yellow-500/10 flex items-center justify-center">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                </span>
                Reviews
            </h2>
        </div>

        @if($reviewTotal === 0)
        <div class="glass-card rounded-2xl p-14 text-center">
            <i class="fas fa-star text-4xl text-slate-200 dark:text-slate-700 mb-3 block"></i>
            <p class="text-sm text-slate-500 dark:text-slate-400">No reviews yet — share your portfolio to collect feedback.</p>
        </div>
        @else

        {{-- Overall rating + breakdown --}}
        <div class="glass-card rounded-2xl p-6 mb-5">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">

                {{-- Big score --}}
                <div class="flex flex-col items-center justify-center sm:border-r border-slate-100 dark:border-white/8 sm:pr-6 sm:min-w-[140px]">
                    <span class="text-6xl font-display font-bold text-slate-900 dark:text-white leading-none">{{ $reviewAvg }}</span>
                    <div class="flex gap-0.5 mt-2">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-base {{ $i <= round($reviewAvg) ? 'text-yellow-400' : 'text-slate-200 dark:text-slate-700' }}"></i>
                        @endfor
                    </div>
                    <span class="text-xs text-slate-400 mt-1.5">{{ $reviewTotal }} {{ $reviewTotal === 1 ? 'review' : 'reviews' }}</span>
                </div>

                {{-- Star breakdown bars --}}
                <div class="flex-1 space-y-2">
                    @foreach([5,4,3,2,1] as $star)
                    @php $pct = $reviewTotal > 0 ? round($reviewBreakdown[$star] / $reviewTotal * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1 w-14 flex-shrink-0">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 tabular-nums">{{ $star }}</span>
                            <i class="fas fa-star text-[10px] text-yellow-400"></i>
                        </div>
                        <div class="flex-1 h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-yellow-400 rounded-full transition-all"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-xs text-slate-400 tabular-nums w-8 text-right">{{ $reviewBreakdown[$star] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Reviews list --}}
        <div class="space-y-3">
            @foreach($reviews as $r)
            <div class="glass-card rounded-2xl p-5">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        {{-- Avatar initials --}}
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 mt-0.5">
                            {{ strtoupper(mb_substr($r['name'], 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $r['name'] }}</span>
                                @if($r['location'])
                                <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                    @if($r['flag'])<span>{{ $r['flag'] }}</span>@endif
                                    {{ $r['location'] }}
                                </span>
                                @endif
                            </div>
                            @if($r['feedback'])
                            <p class="text-[13px] text-slate-600 dark:text-slate-300 leading-relaxed mt-1.5">
                                "{{ $r['feedback'] }}"
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-xs {{ $i <= $r['rating'] ? 'text-yellow-400' : 'text-slate-200 dark:text-slate-700' }}"></i>
                            @endfor
                        </div>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">{{ $r['ago'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @endif
    </div>

    @endif

</div>
