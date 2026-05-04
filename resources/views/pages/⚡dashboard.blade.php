<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Portfolio;

new #[Title('Dashboard — Folio')] #[Layout('layouts::saas')] class extends Component
{
    use WithFileUploads;

    public bool $saved = false;

    // Profile
    public string $hero_name      = '';
    public string $hero_title     = '';
    public string $hero_bio       = '';
    public bool   $hero_available = true;
    public string $hero_avatar    = '';
    public string $hero_github    = '';
    public string $hero_linkedin  = '';

    // File uploads — profile & projects
    public $avatarUpload        = null;
    public $projectImageUpload  = null;
    public int $projectImageIndex = -1;

    // File uploads — tech stack icons
    public $categoryIconUpload  = null;
    public int $categoryIconTarget = -1;
    public $itemIconUpload      = null;
    public array $itemIconTarget = [-1, -1];

    // Stats
    public int $stat_startups = 0;
    public int $stat_years    = 0;
    public int $stat_projects = 0;

    // Tech stack — categorized: [['name'=>'', 'icon'=>'', 'color'=>'', 'items'=>[]]]
    public array $tech_stack = [];

    // Experience
    public array $experience = [];

    // Projects
    public array $projects = [];

    // Contact
    public string $contact_email      = '';
    public string $contact_location   = '';
    public string $contact_phone      = '';
    public string $contact_calendly   = '';
    public string $contact_upwork     = '';
    public string $contact_fiverr     = '';
    public string $contact_freelancer = '';

    public function mount(): void
    {
        if (Auth::user()->is_admin) {
            redirect()->route('admin');
            return;
        }

        $portfolio = Auth::user()->portfolio;
        if (!$portfolio) return;

        $this->hero_name      = $portfolio->hero_name ?? '';
        $this->hero_title     = $portfolio->hero_title ?? '';
        $this->hero_bio       = $portfolio->hero_bio ?? '';
        $this->hero_available = $portfolio->hero_available ?? true;
        $this->hero_avatar    = $portfolio->hero_avatar ?? '';
        $this->hero_github    = $portfolio->hero_github ?? '';
        $this->hero_linkedin  = $portfolio->hero_linkedin ?? '';
        $this->stat_startups  = $portfolio->stat_startups ?? 0;
        $this->stat_years     = $portfolio->stat_years ?? 0;
        $this->stat_projects  = $portfolio->stat_projects ?? 0;
        $this->experience     = $portfolio->experience ?? [];
        $this->projects       = $portfolio->projects ?? [];
        $this->contact_email      = $portfolio->contact_email ?? '';
        $this->contact_location   = $portfolio->contact_location ?? '';
        $this->contact_phone      = $portfolio->contact_phone ?? '';
        $this->contact_calendly   = $portfolio->contact_calendly ?? '';
        $this->contact_upwork     = $portfolio->contact_upwork ?? '';
        $this->contact_fiverr     = $portfolio->contact_fiverr ?? '';
        $this->contact_freelancer = $portfolio->contact_freelancer ?? '';

        // Migrate flat array to categorized if needed, then normalise icon_type fields
        $raw = $portfolio->tech_stack ?? [];
        if (!empty($raw) && is_string($raw[0] ?? null)) {
            $raw = [
                ['name' => 'Technologies', 'icon_type' => 'fa', 'icon' => 'fas fa-code', 'color' => 'blue', 'items' => $raw],
            ];
        }
        foreach ($raw as &$cat) {
            if (!isset($cat['icon_type'])) $cat['icon_type'] = 'fa';
            $normalised = [];
            foreach ($cat['items'] ?? [] as $item) {
                if (is_string($item)) {
                    $normalised[] = ['text' => $item, 'icon_type' => 'fa', 'icon' => ''];
                } else {
                    if (!isset($item['icon_type'])) $item['icon_type'] = 'fa';
                    $normalised[] = $item;
                }
            }
            $cat['items'] = $normalised;
        }
        unset($cat);
        $this->tech_stack = $raw;
    }

    // ---- Avatar upload ----

    public function updatedAvatarUpload(): void
    {
        $this->validate(['avatarUpload' => ['image', 'max:2048']]);
    }

    // ---- Project image upload ----

    public function updatedProjectImageUpload(): void
    {
        $this->validate(['projectImageUpload' => ['image', 'max:5120']]);
    }

    public function confirmProjectImage(int $i): void
    {
        $this->validate(['projectImageUpload' => ['required', 'image', 'max:5120']]);
        $path = $this->projectImageUpload->store('projects', 'public');
        $this->projects[$i]['image'] = $path;
        $this->projectImageUpload  = null;
        $this->projectImageIndex   = -1;
    }

    public function cancelProjectImage(): void
    {
        $this->projectImageUpload = null;
        $this->projectImageIndex  = -1;
    }

    // ---- Tech stack categories ----

    public function addCategory(): void
    {
        $this->tech_stack[] = ['name' => '', 'icon_type' => 'fa', 'icon' => 'fas fa-code', 'color' => 'blue', 'items' => []];
    }

    public function removeCategory(int $i): void
    {
        array_splice($this->tech_stack, $i, 1);
    }

    public function addCategoryItem(int $i): void
    {
        $this->tech_stack[$i]['items'][] = ['text' => '', 'icon_type' => 'fa', 'icon' => ''];
    }

    public function removeCategoryItem(int $i, int $j): void
    {
        array_splice($this->tech_stack[$i]['items'], $j, 1);
    }

    // ---- Category icon upload ----

    public function updatedCategoryIconUpload(): void
    {
        $this->validate(['categoryIconUpload' => ['mimes:jpg,jpeg,png,gif,webp,svg', 'max:1024']]);
    }

    public function confirmCategoryIcon(int $ci): void
    {
        $this->validate(['categoryIconUpload' => ['required', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:1024']]);
        $path = $this->categoryIconUpload->store('tech-icons', 'public');
        $this->tech_stack[$ci]['icon']      = $path;
        $this->tech_stack[$ci]['icon_type'] = 'image';
        $this->categoryIconUpload  = null;
        $this->categoryIconTarget  = -1;
    }

    public function cancelCategoryIcon(): void
    {
        $this->categoryIconUpload = null;
        $this->categoryIconTarget = -1;
    }

    // ---- Item icon upload ----

    public function updatedItemIconUpload(): void
    {
        $this->validate(['itemIconUpload' => ['mimes:jpg,jpeg,png,gif,webp,svg', 'max:1024']]);
    }

    public function confirmItemIcon(int $ci, int $ji): void
    {
        $this->validate(['itemIconUpload' => ['required', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:1024']]);
        $path = $this->itemIconUpload->store('tech-icons', 'public');
        $this->tech_stack[$ci]['items'][$ji]['icon']      = $path;
        $this->tech_stack[$ci]['items'][$ji]['icon_type'] = 'image';
        $this->itemIconUpload = null;
        $this->itemIconTarget = [-1, -1];
    }

    public function cancelItemIcon(): void
    {
        $this->itemIconUpload = null;
        $this->itemIconTarget = [-1, -1];
    }

    public function openItemIconUpload(int $ci, int $ji): void
    {
        $this->itemIconTarget = [$ci, $ji];
    }

    public function updatedTechStack($value, $key): void
    {
        // Auto-open file picker when user switches an item's icon type to 'image'
        if ($value === 'image' && str_ends_with((string)$key, '.icon_type')) {
            $parts = explode('.', (string)$key);
            if (count($parts) === 4 && $parts[1] === 'items') {
                $this->itemIconTarget = [(int)$parts[0], (int)$parts[2]];
            }
        }
    }

    // ---- Experience ----

    public function addExperience(): void
    {
        $this->experience[] = ['company' => '', 'title' => '', 'period' => '', 'description' => ''];
    }

    public function removeExperience(int $i): void
    {
        array_splice($this->experience, $i, 1);
    }

    // ---- Projects ----

    public function addProject(): void
    {
        $this->projects[] = ['name' => '', 'description' => '', 'tech' => '', 'github' => '', 'url' => '', 'image' => ''];
    }

    public function removeProject(int $i): void
    {
        array_splice($this->projects, $i, 1);
    }

    // ---- Save ----

    public function save(): void
    {
        $this->validate([
            'avatarUpload'        => ['nullable', 'image', 'max:2048'],
            'projectImageUpload'  => ['nullable', 'image', 'max:5120'],
            'categoryIconUpload'  => ['nullable', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:1024'],
            'itemIconUpload'      => ['nullable', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:1024'],
        ]);

        $user = Auth::user();
        $portfolio = $user->portfolio ?? new Portfolio(['user_id' => $user->id]);

        $avatarPath = $this->hero_avatar;
        if ($this->avatarUpload) {
            $avatarPath = $this->avatarUpload->store('avatars', 'public');
            $this->avatarUpload = null;
        }

        $portfolio->fill([
            'hero_name'         => $this->hero_name,
            'hero_title'        => $this->hero_title,
            'hero_bio'          => $this->hero_bio,
            'hero_available'    => $this->hero_available,
            'hero_avatar'       => $avatarPath,
            'hero_github'       => $this->hero_github,
            'hero_linkedin'     => $this->hero_linkedin,
            'stat_startups'     => $this->stat_startups,
            'stat_years'        => $this->stat_years,
            'stat_projects'     => $this->stat_projects,
            'tech_stack'        => $this->tech_stack,
            'experience'        => $this->experience,
            'projects'          => $this->projects,
            'contact_email'      => $this->contact_email,
            'contact_location'   => $this->contact_location,
            'contact_phone'      => $this->contact_phone,
            'contact_calendly'   => $this->contact_calendly,
            'contact_upwork'     => $this->contact_upwork,
            'contact_fiverr'     => $this->contact_fiverr,
            'contact_freelancer' => $this->contact_freelancer,
        ]);

        $portfolio->save();

        $this->hero_avatar = $avatarPath;
        $this->saved       = true;
        $this->dispatch('portfolio-saved');
    }

};
?>

<div x-data="{ saved: false, tab: 'profile' }" @portfolio-saved.window="saved = true; setTimeout(() => saved = false, 2500)">

    {{-- ========== TOP BANNER ========== --}}
    <div class="bg-white/60 dark:bg-slate-900/50 border-b border-slate-200 dark:border-white/5 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-display font-bold text-slate-900 dark:text-white">
                        Welcome, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Keep your portfolio fresh and up to date.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/u/' . auth()->user()->username) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl glass border border-slate-200 dark:border-white/10 text-sm font-medium text-slate-700 dark:text-slate-300 hover:border-brand-accent/40 transition-all">
                        <i class="fas fa-external-link-alt text-xs text-brand-accent"></i>
                        /u/{{ auth()->user()->username }}
                    </a>
                    <button wire:click="save"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-85 transition-all shadow-md">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save text-xs mr-0.5"></i> Save
                        </span>
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-1.5">
                            <i class="fas fa-circle-notch fa-spin text-xs"></i> Saving…
                        </span>
                    </button>
                </div>
            </div>

            {{-- Saved toast --}}
            <div x-show="saved"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 text-sm text-emerald-700 dark:text-emerald-400"
                 style="display:none">
                <i class="fas fa-check-circle"></i> Portfolio saved and published!
            </div>
        </div>
    </div>

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-7">

            {{-- ---- Sidebar Tabs ---- --}}
            <aside class="lg:w-52 flex-shrink-0">
                <nav class="space-y-1">
                    @php
                    $tabs = [
                        ['id' => 'profile',    'icon' => 'fas fa-user',       'label' => 'Profile'],
                        ['id' => 'stats',      'icon' => 'fas fa-chart-bar',  'label' => 'Stats'],
                        ['id' => 'skills',     'icon' => 'fas fa-code',       'label' => 'Tech Stack'],
                        ['id' => 'experience', 'icon' => 'fas fa-briefcase',  'label' => 'Experience'],
                        ['id' => 'projects',   'icon' => 'fas fa-folder',     'label' => 'Projects'],
                        ['id' => 'contact',    'icon' => 'fas fa-envelope',   'label' => 'Contact'],
                    ];
                    @endphp
                    @foreach($tabs as $tab)
                    <button @click="tab = '{{ $tab['id'] }}'"
                            :class="tab === '{{ $tab['id'] }}'
                                ? 'bg-brand-accent text-white shadow-md shadow-brand-accent/20'
                                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5'"
                            class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all">
                        <i class="{{ $tab['icon'] }} text-xs w-4 text-center"
                           :class="tab === '{{ $tab['id'] }}' ? 'text-white' : 'opacity-60'"></i>
                        {{ $tab['label'] }}
                    </button>
                    @endforeach
                </nav>
            </aside>

            {{-- ---- Form Panel ---- --}}
            <div class="flex-1 min-w-0">
                <div class="glass-card rounded-2xl p-7 md:p-8">

                    {{-- ======================== PROFILE TAB ======================== --}}
                    <div x-show="tab === 'profile'">
                    <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-user text-brand-accent text-base"></i> Profile
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Profile Picture Upload --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Profile Picture</label>
                            <div class="flex items-center gap-4">
                                {{-- Avatar preview --}}
                                @php
                                $previewUrl = $avatarUpload
                                    ? null
                                    : ($hero_avatar
                                        ? (str_starts_with($hero_avatar, 'http') ? $hero_avatar : asset('storage/' . $hero_avatar))
                                        : null);
                                @endphp

                                @if($avatarUpload)
                                <img src="{{ $avatarUpload->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded-full object-cover border-2 border-brand-accent/30 flex-shrink-0">
                                @elseif($previewUrl)
                                <img src="{{ $previewUrl }}" alt="{{ $hero_name }}" class="w-16 h-16 rounded-full object-cover border border-slate-200 dark:border-white/10 flex-shrink-0">
                                @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                @endif

                                <div class="flex-1">
                                    <label class="block w-full cursor-pointer">
                                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-dashed border-slate-300 dark:border-white/20 hover:border-brand-accent/50 transition-colors text-sm text-slate-500 dark:text-slate-400 hover:text-brand-accent">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>{{ $avatarUpload ? 'New photo selected' : 'Click to upload photo' }}</span>
                                        </div>
                                        <input wire:model="avatarUpload" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">JPG, PNG, WebP · Max 2 MB</p>
                                    @error('avatarUpload') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div wire:loading wire:target="avatarUpload" class="mt-2 text-xs text-brand-accent flex items-center gap-1.5">
                                <i class="fas fa-circle-notch fa-spin text-[10px]"></i> Uploading…
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Full name</label>
                            <input wire:model="hero_name" type="text" placeholder="Alex Mercer" class="input-field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Title / Role</label>
                            <input wire:model="hero_title" type="text" placeholder="Senior Full Stack Engineer" class="input-field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Bio <span class="text-slate-400 font-normal text-xs">(1–2 sentences)</span></label>
                            <textarea wire:model="hero_bio" rows="3" placeholder="I build things that actually work. Passionate about AI infra, Laravel, and shipping fast." class="input-field resize-none"></textarea>
                        </div>
                        <div class="md:col-span-2 flex items-center pt-1">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative">
                                    <input wire:model="hero_available" type="checkbox" class="sr-only peer">
                                    <div class="w-10 h-5 rounded-full bg-slate-200 dark:bg-slate-700 peer-checked:bg-brand-accent transition-colors"></div>
                                    <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Available for work</span>
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><i class="fab fa-github text-slate-400 mr-1"></i> GitHub URL</label>
                            <input wire:model="hero_github" type="url" placeholder="https://github.com/username" class="input-field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><i class="fab fa-linkedin text-slate-400 mr-1"></i> LinkedIn URL</label>
                            <input wire:model="hero_linkedin" type="url" placeholder="https://linkedin.com/in/username" class="input-field">
                        </div>
                    </div>
                    </div>{{-- /profile --}}

                    {{-- ======================== STATS TAB ======================== --}}
                    <div x-show="tab === 'stats'" style="display:none">
                    <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-brand-accent text-base"></i> Stats
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">These numbers appear as highlights on your portfolio.</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Projects shipped</label>
                            <input wire:model="stat_projects" type="number" min="0" placeholder="0" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Startups served</label>
                            <input wire:model="stat_startups" type="number" min="0" placeholder="0" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Years of experience</label>
                            <input wire:model="stat_years" type="number" min="0" placeholder="0" class="input-field">
                        </div>
                    </div>
                    </div>{{-- /stats --}}

                    {{-- ======================== TECH STACK TAB ======================== --}}
                    <div x-show="tab === 'skills'" style="display:none">

                    @php
                    $colorOptions = [
                        'blue'=>'Blue','violet'=>'Violet','emerald'=>'Green','red'=>'Red',
                        'amber'=>'Amber','cyan'=>'Cyan','orange'=>'Orange','pink'=>'Pink',
                    ];
                    $colorAccent = [
                        'blue'   => 'border-l-blue-500',   'violet' => 'border-l-violet-500',
                        'emerald'=> 'border-l-emerald-500', 'red'    => 'border-l-red-500',
                        'amber'  => 'border-l-amber-500',   'cyan'   => 'border-l-cyan-500',
                        'orange' => 'border-l-orange-500',  'pink'   => 'border-l-pink-500',
                    ];
                    $colorIcon = [
                        'blue'   => 'bg-blue-100 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400',
                        'violet' => 'bg-violet-100 dark:bg-violet-500/15 text-violet-600 dark:text-violet-400',
                        'emerald'=> 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400',
                        'red'    => 'bg-red-50 dark:bg-red-500/15 text-red-500 dark:text-red-400',
                        'amber'  => 'bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400',
                        'cyan'   => 'bg-cyan-50 dark:bg-cyan-500/15 text-cyan-600 dark:text-cyan-400',
                        'orange' => 'bg-orange-50 dark:bg-orange-500/15 text-orange-500 dark:text-orange-400',
                        'pink'   => 'bg-pink-50 dark:bg-pink-500/15 text-pink-500 dark:text-pink-400',
                    ];
                    @endphp

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="fas fa-code text-brand-accent text-base"></i> Tech Stack
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Each category becomes a card on your portfolio. Icons can be Font Awesome classes or uploaded images.</p>
                        </div>
                        <button wire:click="addCategory" type="button"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-accent text-white text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm shadow-brand-accent/20 flex-shrink-0">
                            <i class="fas fa-plus text-xs"></i> New category
                        </button>
                    </div>

                    @forelse($tech_stack as $ci => $cat)
                    @php
                    $accent   = $colorAccent[$cat['color'] ?? 'blue'] ?? 'border-l-blue-500';
                    $iconCls  = $colorIcon[$cat['color'] ?? 'blue'] ?? $colorIcon['blue'];
                    $catType  = $cat['icon_type'] ?? 'fa';
                    $catIcon  = $cat['icon'] ?? '';
                    $catImgSrc = ($catType === 'image' && !empty($catIcon))
                        ? (str_starts_with($catIcon, 'http') ? $catIcon : asset('storage/' . $catIcon))
                        : null;
                    @endphp

                    <div class="border border-slate-200 dark:border-white/10 border-l-4 {{ $accent }} rounded-2xl overflow-hidden mb-4 bg-white/60 dark:bg-slate-800/30 backdrop-blur-sm" wire:key="cat-{{ $ci }}">

                        {{-- ── Card header: icon preview + name + color + delete ── --}}
                        <div class="flex items-center gap-3 px-4 py-3.5 bg-white/70 dark:bg-slate-900/50 border-b border-slate-200 dark:border-white/5">
                            {{-- Live icon preview --}}
                            <div class="w-10 h-10 rounded-xl {{ $iconCls }} flex items-center justify-center flex-shrink-0 text-lg">
                                @if($catImgSrc)
                                    <img src="{{ $catImgSrc }}" class="w-6 h-6 object-contain" alt="icon">
                                @elseif($catType === 'fa' && !empty($catIcon))
                                    <i class="{{ $catIcon }}"></i>
                                @else
                                    <i class="fas fa-layer-group opacity-40"></i>
                                @endif
                            </div>
                            {{-- Name input --}}
                            <input wire:model="tech_stack.{{ $ci }}.name" type="text"
                                   placeholder="Category name (e.g. Backend)"
                                   class="flex-1 bg-transparent font-bold text-slate-900 dark:text-white text-sm outline-none placeholder-slate-400 min-w-0">
                            {{-- Color picker --}}
                            <select wire:model="tech_stack.{{ $ci }}.color"
                                    class="text-xs bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-white/10 rounded-lg px-2 py-1.5 text-slate-600 dark:text-slate-300 outline-none cursor-pointer flex-shrink-0">
                                @foreach($colorOptions as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            {{-- Delete --}}
                            <button wire:click="removeCategory({{ $ci }})" type="button"
                                    class="w-7 h-7 rounded-full flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all flex-shrink-0">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>

                        {{-- ── Category icon picker ── --}}
                        <div class="px-4 py-3 border-b border-slate-100 dark:border-white/5 bg-slate-50/60 dark:bg-slate-900/20">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex-shrink-0">Icon:</span>

                                {{-- Toggle FA / Image --}}
                                <div class="flex rounded-lg overflow-hidden border border-slate-200 dark:border-white/10 text-[11px] font-bold flex-shrink-0">
                                    <button type="button" wire:click="$set('tech_stack.{{ $ci }}.icon_type', 'fa')"
                                            class="px-2.5 py-1.5 transition-all {{ $catType === 'fa' ? 'bg-brand-accent text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <i class="fas fa-font mr-1"></i>Font Awesome
                                    </button>
                                    <button type="button" wire:click="$set('tech_stack.{{ $ci }}.icon_type', 'image')"
                                            class="px-2.5 py-1.5 border-l border-slate-200 dark:border-white/10 transition-all {{ $catType === 'image' ? 'bg-brand-accent text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <i class="fas fa-image mr-1"></i>Upload
                                    </button>
                                </div>

                                @if($catType === 'fa')
                                {{-- FA class input --}}
                                <input wire:model="tech_stack.{{ $ci }}.icon" type="text"
                                       placeholder="fas fa-code"
                                       class="flex-1 min-w-[160px] font-mono text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-1.5 outline-none focus:border-brand-accent text-slate-700 dark:text-slate-200 placeholder-slate-400">
                                <span class="text-[10px] text-slate-400 hidden md:inline">
                                    e.g. <code class="font-mono">fas fa-brain</code> · <code class="font-mono">fab fa-laravel</code> · <code class="font-mono">fab fa-python</code>
                                </span>
                                @else
                                {{-- Image upload --}}
                                @if($catImgSrc)
                                <div class="flex items-center gap-2">
                                    <img src="{{ $catImgSrc }}" class="w-8 h-8 object-contain rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-800 p-0.5">
                                    <button type="button"
                                            wire:click="$set('tech_stack.{{ $ci }}.icon', ''); $set('tech_stack.{{ $ci }}.icon_type', 'fa')"
                                            class="text-[11px] text-red-500 hover:underline font-medium">Remove</button>
                                </div>
                                @elseif($categoryIconTarget === $ci)
                                    @if($categoryIconUpload)
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $categoryIconUpload->temporaryUrl() }}" class="w-8 h-8 object-contain rounded-lg border border-brand-accent/30 bg-white dark:bg-slate-800 p-0.5">
                                        <button wire:click="confirmCategoryIcon({{ $ci }})" type="button"
                                                class="px-2.5 py-1 rounded-lg bg-emerald-500 text-white text-[11px] font-bold hover:bg-emerald-600 transition-colors">
                                            <i class="fas fa-check mr-0.5"></i> Use
                                        </button>
                                        <button wire:click="cancelCategoryIcon" type="button" class="text-[11px] text-slate-400 hover:text-slate-600">Cancel</button>
                                    </div>
                                    @else
                                    <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-dashed border-brand-accent/40 hover:border-brand-accent text-[11px] text-brand-accent font-semibold transition-colors">
                                        <i class="fas fa-cloud-upload-alt"></i> Choose file
                                        <input wire:model="categoryIconUpload" type="file" accept="image/*,.svg" class="sr-only">
                                    </label>
                                    <button wire:click="cancelCategoryIcon" type="button" class="text-[11px] text-slate-400 hover:text-slate-600 ml-1">Cancel</button>
                                    <div wire:loading wire:target="categoryIconUpload" class="text-[11px] text-brand-accent flex items-center gap-1">
                                        <i class="fas fa-circle-notch fa-spin"></i> Uploading…
                                    </div>
                                    @endif
                                @else
                                <button wire:click="$set('categoryIconTarget', {{ $ci }})" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-dashed border-slate-300 dark:border-white/20 hover:border-brand-accent/50 text-[11px] text-slate-500 dark:text-slate-400 hover:text-brand-accent font-semibold transition-colors">
                                    <i class="fas fa-upload"></i> Choose image / SVG
                                </button>
                                @endif
                                @endif
                            </div>
                        </div>

                        {{-- ── Items list ── --}}
                        <div class="px-4 pt-3 pb-4">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Items</span>
                                <span class="text-[11px] text-slate-400">{{ count($cat['items'] ?? []) }} item{{ count($cat['items'] ?? []) !== 1 ? 's' : '' }}</span>
                            </div>

                            <div class="space-y-2 mb-3">
                                @forelse($cat['items'] ?? [] as $ji => $item)
                                @php
                                $iText    = is_array($item) ? ($item['text'] ?? '') : $item;
                                $iType    = is_array($item) ? ($item['icon_type'] ?? 'fa') : 'fa';
                                $iIcon    = is_array($item) ? ($item['icon'] ?? '') : '';
                                $iImgSrc  = ($iType === 'image' && !empty($iIcon))
                                    ? (str_starts_with($iIcon, 'http') ? $iIcon : asset('storage/' . $iIcon))
                                    : null;
                                @endphp
                                <div class="rounded-xl border border-slate-100 dark:border-white/5 bg-white/50 dark:bg-slate-900/30 overflow-hidden group" wire:key="item-{{ $ci }}-{{ $ji }}">

                                    {{-- Main row --}}
                                    <div class="flex items-center gap-2.5 px-3 py-2">

                                        {{-- Icon preview --}}
                                        <div class="flex-shrink-0 w-8 h-8 rounded-lg {{ $iconCls }} flex items-center justify-center text-sm select-none">
                                            @if($iImgSrc)
                                                <img src="{{ $iImgSrc }}" class="w-5 h-5 object-contain" alt="">
                                            @elseif($iType === 'fa' && !empty($iIcon))
                                                <i class="{{ $iIcon }}"></i>
                                            @else
                                                <span class="text-[10px] font-bold opacity-30">—</span>
                                            @endif
                                        </div>

                                        {{-- Type selector --}}
                                        <select wire:model.live="tech_stack.{{ $ci }}.items.{{ $ji }}.icon_type"
                                                class="flex-shrink-0 text-[11px] bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-white/10 rounded-lg px-2 py-1.5 text-slate-500 dark:text-slate-400 outline-none cursor-pointer">
                                            <option value="fa">Font Awesome</option>
                                            <option value="image">Image / SVG</option>
                                            <option value="none">No icon</option>
                                        </select>

                                        @if($iType === 'fa')
                                        {{-- FA class input --}}
                                        <input wire:model="tech_stack.{{ $ci }}.items.{{ $ji }}.icon" type="text"
                                               placeholder="fab fa-laravel"
                                               class="w-32 font-mono text-[12px] bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-lg px-2.5 py-1.5 outline-none focus:border-brand-accent text-slate-600 dark:text-slate-300 placeholder-slate-300 flex-shrink-0">
                                        @endif

                                        {{-- Item label --}}
                                        <input wire:model="tech_stack.{{ $ci }}.items.{{ $ji }}.text" type="text"
                                               placeholder="e.g. Laravel"
                                               class="flex-1 min-w-0 text-sm bg-transparent border-b border-slate-200 dark:border-white/10 focus:border-brand-accent outline-none py-1 text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600 transition-colors">

                                        {{-- Delete --}}
                                        <button wire:click="removeCategoryItem({{ $ci }}, {{ $ji }})" type="button"
                                                class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 opacity-0 group-hover:opacity-100 transition-all">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>

                                    {{-- Image upload panel (shown when type = image) --}}
                                    @if($iType === 'image')
                                    <div class="mx-3 mb-3 rounded-xl border border-dashed border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/40 p-3">
                                        @if($iImgSrc)
                                            {{-- Confirmed image --}}
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $iImgSrc }}" alt="icon" class="w-10 h-10 object-contain rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-800 p-1 flex-shrink-0">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">Icon uploaded</p>
                                                    <p class="text-[11px] text-slate-400 truncate">{{ basename($iIcon) }}</p>
                                                </div>
                                                <button type="button"
                                                        wire:click="$set('tech_stack.{{ $ci }}.items.{{ $ji }}.icon', '')"
                                                        class="flex-shrink-0 px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-500 text-xs font-semibold hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
                                                    <i class="fas fa-trash-alt mr-1 text-[10px]"></i>Remove
                                                </button>
                                            </div>
                                        @elseif($itemIconTarget[0] === $ci && $itemIconTarget[1] === $ji)
                                            @if($itemIconUpload)
                                                {{-- Preview before confirm --}}
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ $itemIconUpload->temporaryUrl() }}" alt="preview" class="w-10 h-10 object-contain rounded-lg border border-brand-accent/30 bg-white dark:bg-slate-800 p-1 flex-shrink-0">
                                                    <div class="flex-1">
                                                        <p class="text-xs font-semibold text-slate-600 dark:text-slate-300 mb-1.5">Looks good?</p>
                                                        <div class="flex items-center gap-2">
                                                            <button wire:click="confirmItemIcon({{ $ci }}, {{ $ji }})" type="button"
                                                                    class="px-3 py-1.5 rounded-lg bg-emerald-500 text-white text-xs font-bold hover:bg-emerald-600 transition-colors">
                                                                <i class="fas fa-check mr-1"></i>Use this icon
                                                            </button>
                                                            <button wire:click="cancelItemIcon" type="button"
                                                                    class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10 text-xs text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- File picker --}}
                                                <label class="flex flex-col items-center gap-1.5 cursor-pointer py-2">
                                                    <div class="w-9 h-9 rounded-xl bg-brand-accent/10 dark:bg-brand-accent/20 flex items-center justify-center text-brand-accent">
                                                        <i class="fas fa-cloud-upload-alt text-base"></i>
                                                    </div>
                                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">Click to choose file</span>
                                                    <span class="text-[11px] text-slate-400">PNG, JPG, SVG · max 1 MB</span>
                                                    <input wire:model="itemIconUpload" type="file" accept="image/*,.svg" class="sr-only">
                                                </label>
                                                <div wire:loading wire:target="itemIconUpload" class="flex items-center justify-center gap-2 py-1 text-xs text-brand-accent">
                                                    <i class="fas fa-circle-notch fa-spin"></i> Uploading…
                                                </div>
                                                <div class="flex justify-center mt-1">
                                                    <button wire:click="cancelItemIcon" type="button"
                                                            class="text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                                        Cancel
                                                    </button>
                                                </div>
                                            @endif
                                        @else
                                            {{-- Idle: one click to activate then file picker appears --}}
                                            <button wire:click="openItemIconUpload({{ $ci }}, {{ $ji }})" type="button"
                                                    class="w-full flex items-center justify-center gap-2 py-3 text-sm font-semibold text-brand-accent hover:text-blue-700 transition-colors">
                                                <i class="fas fa-cloud-upload-alt text-base"></i>
                                                Click to choose icon
                                            </button>
                                        @endif
                                    </div>
                                    @endif

                                </div>
                                @empty
                                <p class="text-xs text-slate-400 italic py-2">No items yet — add one below.</p>
                                @endforelse
                            </div>

                            <button wire:click="addCategoryItem({{ $ci }})" type="button"
                                    class="inline-flex items-center gap-1.5 text-xs text-brand-accent font-semibold hover:bg-brand-accent/8 px-2 py-1 rounded-lg transition-colors">
                                <i class="fas fa-plus text-[10px]"></i> Add item
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 border-2 border-dashed border-slate-200 dark:border-white/10 rounded-2xl">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-layer-group text-2xl text-slate-300 dark:text-slate-600"></i>
                        </div>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-1">No categories yet</p>
                        <p class="text-xs text-slate-400 mb-4">Group your skills into categories like Backend, AI, Frontend…</p>
                        <button wire:click="addCategory" type="button"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-accent text-white text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">
                            <i class="fas fa-plus text-xs"></i> Add first category
                        </button>
                    </div>
                    @endforelse
                    </div>{{-- /skills --}}

                    {{-- ======================== EXPERIENCE TAB ======================== --}}
                    <div x-show="tab === 'experience'" style="display:none">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-briefcase text-brand-accent text-base"></i> Experience
                        </h2>
                        <button wire:click="addExperience" type="button"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-brand-accent/10 dark:bg-brand-accent/15 text-brand-accent text-sm font-semibold hover:bg-brand-accent/20 transition-colors">
                            <i class="fas fa-plus text-xs"></i> Add entry
                        </button>
                    </div>

                    @forelse($experience as $i => $exp)
                    <div class="glass rounded-2xl p-6 mb-4 relative">
                        <button wire:click="removeExperience({{ $i }})" type="button"
                                class="absolute top-4 right-4 w-7 h-7 rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-8">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Company</label>
                                <input wire:model="experience.{{ $i }}.company" type="text" placeholder="Acme Corp" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Your title</label>
                                <input wire:model="experience.{{ $i }}.title" type="text" placeholder="Senior Developer" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Period</label>
                                <input wire:model="experience.{{ $i }}.period" type="text" placeholder="2022 — Present" class="input-field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Description</label>
                                <textarea wire:model="experience.{{ $i }}.description" rows="3" placeholder="What you built, led, or achieved…" class="input-field resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-14 border-2 border-dashed border-slate-200 dark:border-white/10 rounded-2xl">
                        <i class="fas fa-briefcase text-3xl text-slate-300 dark:text-slate-600 mb-3 block"></i>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No experience entries yet.</p>
                        <button wire:click="addExperience" type="button" class="mt-3 text-brand-accent text-sm font-semibold hover:underline">
                            + Add your first entry
                        </button>
                    </div>
                    @endforelse
                    </div>{{-- /experience --}}

                    {{-- ======================== PROJECTS TAB ======================== --}}
                    <div x-show="tab === 'projects'" style="display:none">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-folder text-brand-accent text-base"></i> Projects
                        </h2>
                        <button wire:click="addProject" type="button"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-brand-accent/10 dark:bg-brand-accent/15 text-brand-accent text-sm font-semibold hover:bg-brand-accent/20 transition-colors">
                            <i class="fas fa-plus text-xs"></i> Add project
                        </button>
                    </div>

                    @forelse($projects as $i => $project)
                    <div class="glass rounded-2xl p-6 mb-4 relative">
                        <button wire:click="removeProject({{ $i }})" type="button"
                                class="absolute top-4 right-4 w-7 h-7 rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-8">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Project name</label>
                                <input wire:model="projects.{{ $i }}.name" type="text" placeholder="My SaaS App" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Tech used</label>
                                <input wire:model="projects.{{ $i }}.tech" type="text" placeholder="Laravel, Vue, MySQL" class="input-field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Description</label>
                                <textarea wire:model="projects.{{ $i }}.description" rows="2" placeholder="What does this project do?" class="input-field resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1"><i class="fab fa-github mr-1"></i> GitHub URL</label>
                                <input wire:model="projects.{{ $i }}.github" type="url" placeholder="https://github.com/..." class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1"><i class="fas fa-globe mr-1"></i> Live URL</label>
                                <input wire:model="projects.{{ $i }}.url" type="url" placeholder="https://myproject.com" class="input-field">
                            </div>

                            {{-- Project Image Upload --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-2">Project image</label>
                                @php
                                $imgVal = $project['image'] ?? '';
                                $imgSrc = $imgVal
                                    ? (str_starts_with($imgVal, 'http') ? $imgVal : asset('storage/' . $imgVal))
                                    : null;
                                @endphp

                                @if($imgSrc)
                                <div class="relative inline-block mb-2">
                                    <img src="{{ $imgSrc }}" alt="Project image" class="h-28 rounded-xl object-cover border border-slate-200 dark:border-white/10">
                                    <button wire:click="$set('projects.{{ $i }}.image', '')" type="button"
                                            class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center hover:bg-red-600 transition-colors shadow">
                                        <i class="fas fa-times text-[9px]"></i>
                                    </button>
                                </div>
                                @elseif($projectImageIndex === $i)
                                    @if($projectImageUpload)
                                    <div class="space-y-2">
                                        <img src="{{ $projectImageUpload->temporaryUrl() }}" alt="Preview" class="h-28 rounded-xl object-cover border border-brand-accent/30">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="confirmProjectImage({{ $i }})" type="button"
                                                    class="px-3 py-1.5 rounded-lg bg-emerald-500 text-white text-xs font-semibold hover:bg-emerald-600 transition-colors">
                                                <i class="fas fa-check mr-1"></i> Use this image
                                            </button>
                                            <button wire:click="cancelProjectImage" type="button"
                                                    class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10 text-xs font-medium text-slate-500 hover:text-slate-700 transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                        <div wire:loading wire:target="confirmProjectImage" class="text-xs text-brand-accent flex items-center gap-1">
                                            <i class="fas fa-circle-notch fa-spin text-[10px]"></i> Saving…
                                        </div>
                                    </div>
                                    @else
                                    <label class="block cursor-pointer">
                                        <div class="flex items-center gap-2 px-4 py-3 rounded-xl border border-dashed border-brand-accent/40 hover:border-brand-accent transition-colors text-sm text-brand-accent">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>Choose image file</span>
                                        </div>
                                        <input wire:model="projectImageUpload" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <div wire:loading wire:target="projectImageUpload" class="mt-1 text-xs text-brand-accent flex items-center gap-1">
                                        <i class="fas fa-circle-notch fa-spin text-[10px]"></i> Uploading…
                                    </div>
                                    <button wire:click="cancelProjectImage" type="button" class="mt-1 text-xs text-slate-400 hover:text-slate-600 transition-colors">
                                        ← Cancel
                                    </button>
                                    @endif
                                @else
                                <button wire:click="$set('projectImageIndex', {{ $i }})" type="button"
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-dashed border-slate-300 dark:border-white/20 hover:border-brand-accent/50 transition-colors text-sm text-slate-500 dark:text-slate-400 hover:text-brand-accent">
                                    <i class="fas fa-image text-sm"></i>
                                    Upload project image
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-14 border-2 border-dashed border-slate-200 dark:border-white/10 rounded-2xl">
                        <i class="fas fa-folder-open text-3xl text-slate-300 dark:text-slate-600 mb-3 block"></i>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No projects added yet.</p>
                        <button wire:click="addProject" type="button" class="mt-3 text-brand-accent text-sm font-semibold hover:underline">
                            + Add your first project
                        </button>
                    </div>
                    @endforelse
                    </div>{{-- /projects --}}

                    {{-- ======================== CONTACT TAB ======================== --}}
                    <div x-show="tab === 'contact'" style="display:none">
                    <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-envelope text-brand-accent text-base"></i> Contact
                    </h2>

                    {{-- Basic contact info --}}
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Basic info</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><i class="fas fa-envelope text-slate-400 mr-1"></i> Contact email</label>
                            <input wire:model="contact_email" type="email" placeholder="you@example.com" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><i class="fas fa-phone text-slate-400 mr-1"></i> Phone number <span class="text-slate-400 font-normal text-xs">(optional)</span></label>
                            <input wire:model="contact_phone" type="tel" placeholder="+1 555 000 0000" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><i class="fas fa-map-marker-alt text-slate-400 mr-1"></i> Location</label>
                            <input wire:model="contact_location" type="text" placeholder="New York, US — Remote" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><i class="fas fa-calendar text-slate-400 mr-1"></i> Calendly link <span class="text-slate-400 font-normal text-xs">(optional)</span></label>
                            <input wire:model="contact_calendly" type="url" placeholder="https://calendly.com/your-name" class="input-field">
                        </div>
                    </div>

                    {{-- Freelance platforms --}}
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Hire me on <span class="font-normal normal-case tracking-normal text-slate-400">(paste your profile URL)</span></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                <span class="inline-flex items-center gap-1.5"><img src="https://cdn.simpleicons.org/upwork/6FDA44" class="w-4 h-4 inline"> Upwork</span>
                            </label>
                            <input wire:model="contact_upwork" type="url" placeholder="https://www.upwork.com/freelancers/~..." class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                <span class="inline-flex items-center gap-1.5"><img src="https://cdn.simpleicons.org/fiverr/1DBF73" class="w-4 h-4 inline"> Fiverr</span>
                            </label>
                            <input wire:model="contact_fiverr" type="url" placeholder="https://www.fiverr.com/your-username" class="input-field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                <span class="inline-flex items-center gap-1.5"><img src="https://cdn.simpleicons.org/freelancer/29B2FE" class="w-4 h-4 inline"> Freelancer.com</span>
                            </label>
                            <input wire:model="contact_freelancer" type="url" placeholder="https://www.freelancer.com/u/your-username" class="input-field">
                        </div>
                    </div>
                    </div>{{-- /contact --}}


                </div>

                {{-- Bottom save button --}}
                <div class="flex justify-end mt-4">
                    <button wire:click="save"
                            class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:opacity-85 transition-all shadow-md">
                        <span wire:loading.remove wire:target="save"><i class="fas fa-save text-xs mr-0.5"></i> Save changes</span>
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-1.5"><i class="fas fa-circle-notch fa-spin text-xs"></i> Saving…</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
