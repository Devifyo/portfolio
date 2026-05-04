<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\PortfolioView;
use App\Models\PortfolioReview;

new #[Title('Admin — Folio')] #[Layout('layouts::admin')] class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all';   // all | has_portfolio | no_portfolio | published | unpublished
    public string $sort   = 'newest'; // newest | oldest | name | most_views

    public bool   $confirmingDelete = false;
    public ?int   $deletingUserId   = null;
    public string $deleteUserName   = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->is_admin, 403);
    }

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilter(): void { $this->resetPage(); }
    public function updatedSort():   void { $this->resetPage(); }

    #[Computed]
    public function stats(): array
    {
        return [
            'total_users'      => User::where('is_admin', false)->count(),
            'total_portfolios' => Portfolio::whereHas('user', fn($q) => $q->where('is_admin', false))->count(),
            'published'        => Portfolio::where('published', true)->whereHas('user', fn($q) => $q->where('is_admin', false))->count(),
            'total_views'      => PortfolioView::count(),
        ];
    }

    #[Computed]
    public function users()
    {
        $viewsSubquery = DB::table('portfolio_views')
            ->selectRaw('COUNT(*)')
            ->join('portfolios', 'portfolio_views.portfolio_id', '=', 'portfolios.id')
            ->whereColumn('portfolios.user_id', 'users.id');

        $q = User::query()
            ->where('is_admin', false)
            ->with('portfolio')
            ->addSelect(['views_count' => $viewsSubquery]);

        if ($this->search !== '') {
            $s = $this->search;
            $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('username', 'like', "%{$s}%")
            );
        }

        match ($this->filter) {
            'has_portfolio'  => $q->whereHas('portfolio'),
            'no_portfolio'   => $q->whereDoesntHave('portfolio'),
            'published'      => $q->whereHas('portfolio', fn ($q) => $q->where('published', true)),
            'unpublished'    => $q->whereHas('portfolio', fn ($q) => $q->where('published', false)),
            default          => null,
        };

        match ($this->sort) {
            'oldest'     => $q->oldest(),
            'name'       => $q->orderBy('name'),
            'most_views' => $q->orderByDesc('views_count'),
            default      => $q->latest(),
        };

        return $q->paginate(15);
    }

    public function confirmDelete(int $userId): void
    {
        $user = User::find($userId);
        if (!$user || $user->is_admin) return;

        $this->deletingUserId = $userId;
        $this->deleteUserName = $user->name;
        $this->confirmingDelete = true;
    }

    public function deleteUser(): void
    {
        if ($this->deletingUserId) {
            $user = User::find($this->deletingUserId);
            if ($user && !$user->is_admin) {
                $user->delete();
            }
        }
        $this->cancelDelete();
        unset($this->users);
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = false;
        $this->deletingUserId   = null;
        $this->deleteUserName   = '';
    }

    public function togglePublish(int $portfolioId): void
    {
        $portfolio = Portfolio::find($portfolioId);
        if ($portfolio) {
            $portfolio->published = !$portfolio->published;
            $portfolio->save();
        }
        unset($this->users, $this->stats);
    }
};
?>

<div x-data="{ deleteOpen: @entangle('confirmingDelete') }">

    {{-- ── Delete confirmation modal ── --}}
    <div x-show="deleteOpen"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.cancelDelete()"></div>
        <div class="relative admin-card rounded-2xl p-7 w-full max-w-sm shadow-2xl z-10 border border-white/8"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash-alt text-red-400 text-lg"></i>
            </div>
            <h3 class="text-base font-display font-bold text-white text-center mb-1">Delete user?</h3>
            <p class="text-sm text-slate-400 text-center mb-6">
                This will permanently delete <strong class="text-slate-200">{{ $deleteUserName }}</strong> and all their data. This cannot be undone.
            </p>
            <div class="flex gap-3">
                <button wire:click="cancelDelete"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-white/10 text-sm font-semibold text-slate-400 hover:bg-white/5 transition-colors">
                    Cancel
                </button>
                <button wire:click="deleteUser"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors shadow-sm shadow-red-500/20">
                    <span wire:loading.remove wire:target="deleteUser"><i class="fas fa-trash-alt text-xs mr-1"></i>Delete</span>
                    <span wire:loading wire:target="deleteUser" class="inline-flex items-center gap-1.5"><i class="fas fa-circle-notch fa-spin text-xs"></i> Deleting…</span>
                </button>
            </div>
        </div>
    </div>

    <div class="px-6 lg:px-8 py-8 space-y-6">

        {{-- Page heading --}}
        <div>
            <h1 class="text-xl font-display font-bold text-white flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-violet-500/15 flex items-center justify-center">
                    <i class="fas fa-users text-violet-400 text-sm"></i>
                </span>
                Users
            </h1>
            <p class="text-sm text-slate-500 mt-1">Manage registered users and their portfolios.</p>
        </div>

        {{-- ── Stat cards ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @php
            $statCards = [
                ['label' => 'Total Users',  'value' => $this->stats['total_users'],      'icon' => 'fas fa-users',   'bg' => 'bg-blue-500/10',    'ic' => 'text-blue-400',   'val' => 'text-blue-300'],
                ['label' => 'Portfolios',   'value' => $this->stats['total_portfolios'], 'icon' => 'fas fa-id-card', 'bg' => 'bg-violet-500/10',  'ic' => 'text-violet-400', 'val' => 'text-violet-300'],
                ['label' => 'Published',    'value' => $this->stats['published'],        'icon' => 'fas fa-globe',   'bg' => 'bg-emerald-500/10', 'ic' => 'text-emerald-400','val' => 'text-emerald-300'],
                ['label' => 'Total Views',  'value' => $this->stats['total_views'],      'icon' => 'fas fa-eye',     'bg' => 'bg-amber-500/10',   'ic' => 'text-amber-400',  'val' => 'text-amber-300'],
            ];
            @endphp
            @foreach($statCards as $card)
            <div class="admin-card rounded-2xl p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl {{ $card['bg'] }} flex items-center justify-center">
                        <i class="{{ $card['icon'] }} text-sm {{ $card['ic'] }}"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500">{{ $card['label'] }}</span>
                </div>
                <p class="text-4xl font-display font-bold {{ $card['val'] }} leading-none">
                    {{ number_format($card['value']) }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- ── Filters & search ── --}}
        <div class="admin-card rounded-2xl p-5">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                    <input wire:model.live.debounce.300ms="search"
                           type="text"
                           placeholder="Search by name, email or username…"
                           class="input-field pl-9">
                </div>
                <select wire:model.live="filter" class="input-field sm:w-52">
                    <option value="all">All users</option>
                    <option value="has_portfolio">Has portfolio</option>
                    <option value="no_portfolio">No portfolio</option>
                    <option value="published">Published</option>
                    <option value="unpublished">Unpublished</option>
                </select>
                <select wire:model.live="sort" class="input-field sm:w-44">
                    <option value="newest">Newest first</option>
                    <option value="oldest">Oldest first</option>
                    <option value="name">Name A–Z</option>
                    <option value="most_views">Most views</option>
                </select>
            </div>
        </div>

        {{-- ── Users table ── --}}
        <div class="admin-card rounded-2xl overflow-hidden relative">

            <div wire:loading wire:target="search,filter,sort,deleteUser,togglePublish"
                 class="absolute inset-0 bg-[#060b18]/60 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl">
                <i class="fas fa-circle-notch fa-spin text-violet-400 text-xl"></i>
            </div>

            @if($this->users->isEmpty())
            <div class="py-20 text-center">
                <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-slate-600"></i>
                </div>
                <p class="text-sm font-semibold text-slate-400">No users found</p>
                <p class="text-xs text-slate-600 mt-1">Try adjusting your search or filters.</p>
            </div>
            @else

            <div class="hidden md:grid grid-cols-[1fr_160px_110px_90px_130px] gap-4 px-5 py-3 border-b border-white/5 bg-white/3">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">User</span>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Portfolio</span>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider text-center">Views</span>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Joined</span>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider text-right">Actions</span>
            </div>

            <div class="divide-y divide-white/5">
                @foreach($this->users as $user)
                @php
                    $portfolio    = $user->portfolio;
                    $viewCount    = (int)($user->views_count ?? 0);
                    $hasPortfolio = $portfolio !== null;
                    $isPublished  = $hasPortfolio && $portfolio->published;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-[1fr_160px_110px_90px_130px] gap-3 md:gap-4 items-center px-5 py-4 hover:bg-white/3 transition-colors">

                    {{-- User --}}
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-200 truncate">{{ $user->name }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                <span class="text-xs text-slate-500 truncate">{{ $user->email }}</span>
                                @if($user->username)
                                <span class="text-slate-700 text-[10px]">·</span>
                                <span class="text-[11px] font-mono text-slate-600">@{{ $user->username }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Portfolio status --}}
                    <div class="flex md:block items-center gap-2">
                        <span class="md:hidden text-[11px] font-bold text-slate-600 uppercase tracking-wider w-20 flex-shrink-0">Portfolio</span>
                        @if(!$hasPortfolio)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/5 text-slate-500 text-[11px] font-semibold">
                            <i class="fas fa-minus text-[9px]"></i> None
                        </span>
                        @elseif($isPublished)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[11px] font-semibold border border-emerald-500/20">
                            <i class="fas fa-check-circle text-[9px]"></i> Published
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-amber-500/10 text-amber-400 text-[11px] font-semibold border border-amber-500/20">
                            <i class="fas fa-eye-slash text-[9px]"></i> Hidden
                        </span>
                        @endif
                    </div>

                    {{-- Views --}}
                    <div class="flex md:justify-center items-center gap-2">
                        <span class="md:hidden text-[11px] font-bold text-slate-600 uppercase tracking-wider w-20 flex-shrink-0">Views</span>
                        <span class="text-sm font-bold tabular-nums {{ $viewCount > 0 ? 'text-slate-200' : 'text-slate-700' }}">
                            {{ number_format($viewCount) }}
                        </span>
                    </div>

                    {{-- Joined --}}
                    <div class="flex md:block items-center gap-2">
                        <span class="md:hidden text-[11px] font-bold text-slate-600 uppercase tracking-wider w-20 flex-shrink-0">Joined</span>
                        <span class="text-xs text-slate-500">{{ $user->created_at->format('M j, Y') }}</span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-start md:justify-end gap-1">
                        @if($hasPortfolio && $user->username)
                        <a href="{{ url('/u/' . $user->username) }}" target="_blank"
                           class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-500 hover:text-violet-400 hover:bg-violet-500/10 transition-all"
                           title="View portfolio">
                            <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                        @endif

                        @if($hasPortfolio)
                        <button wire:click="togglePublish({{ $portfolio->id }})"
                                title="{{ $isPublished ? 'Unpublish' : 'Publish' }}"
                                class="w-8 h-8 rounded-xl flex items-center justify-center transition-all
                                    {{ $isPublished
                                        ? 'text-emerald-400 hover:text-amber-400 hover:bg-amber-500/10'
                                        : 'text-amber-400 hover:text-emerald-400 hover:bg-emerald-500/10' }}">
                            <i class="fas {{ $isPublished ? 'fa-eye' : 'fa-eye-slash' }} text-xs"></i>
                        </button>
                        @endif

                        <button wire:click="confirmDelete({{ $user->id }})"
                                title="Delete user"
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-700 hover:text-red-400 hover:bg-red-500/10 transition-all">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

            @endif
        </div>

        {{-- ── Pagination ── --}}
        @if($this->users->hasPages())
        <div class="pb-2">
            {{ $this->users->links('pagination::simple-tailwind') }}
        </div>
        @endif

    </div>
</div>
