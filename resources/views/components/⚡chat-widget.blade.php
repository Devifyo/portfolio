<?php

use Livewire\Component;

new class extends Component
{
    public bool $open = false;
    public string $draft = '';

    public array $messages = [
        ['role' => 'ai', 'text' => "Hey 👋 I'm ready to be hooked up to your RAG backend! Test the UI by sending a message below."],
    ];

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function send(): void
    {
        $msg = trim($this->draft);
        if ($msg === '') return;

        $this->messages[] = ['role' => 'user', 'text' => $msg];
        $this->messages[] = [
            'role' => 'ai',
            'text' => "RAG Backend is offline. Please connect your API to process: '{$msg}'",
        ];
        $this->draft = '';
    }
};
?>

<div id="ai-chat-widget" class="fixed bottom-6 right-6 z-[60] font-sans select-none">
    @if($open)
    <div id="chat-window"
         class="flex flex-col mb-3 w-[320px] bg-white dark:bg-[#0e1628] border border-slate-200 dark:border-white/8 rounded-2xl shadow-2xl overflow-hidden"
         style="height:380px;">

        <div class="flex-none bg-gradient-to-r from-blue-600 to-violet-600 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2.5 text-white">
                <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-robot text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-bold leading-none">Portfolio Agent</p>
                    <p class="text-[10px] opacity-70 mt-0.5">RAG Backend Pending</p>
                </div>
            </div>
            <button wire:click="toggle" type="button"
                    class="w-6 h-6 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>

        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-slate-50 dark:bg-slate-950/60" style="overscroll-behavior:contain;">
            @foreach ($messages as $m)
                <div class="flex gap-2 {{ $m['role'] === 'user' ? 'flex-row-reverse' : '' }}">
                    @if ($m['role'] === 'ai')
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-600 to-violet-600 flex-shrink-0 flex items-center justify-center mt-0.5">
                            <i class="fas fa-robot text-[9px] text-white"></i>
                        </div>
                    @endif
                    <div class="{{ $m['role'] === 'user'
                        ? 'bg-brand-accent text-white rounded-2xl rounded-tr-sm px-3 py-2.5 text-[13px] shadow-sm max-w-[82%]'
                        : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-white/5 rounded-2xl rounded-tl-sm px-3 py-2.5 text-[13px] text-slate-600 dark:text-slate-300 shadow-sm max-w-[82%]' }}">
                        {{ $m['text'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex-none p-3 bg-white dark:bg-[#0e1628] border-t border-slate-100 dark:border-white/5">
            <form wire:submit.prevent="send" class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 rounded-full px-3 py-1.5 m-0">
                <input type="text" wire:model="draft"
                       class="flex-1 bg-transparent text-[13px] text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none"
                       placeholder="Type a message…" autocomplete="off">
                <button type="submit" class="w-7 h-7 bg-brand-accent hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors flex-shrink-0">
                    <i class="fas fa-paper-plane text-[10px] text-white"></i>
                </button>
            </form>
        </div>
    </div>
    @endif

    <button wire:click="toggle" type="button" aria-label="Open chat"
            class="w-14 h-14 bg-gradient-to-br from-blue-600 to-violet-600 rounded-full flex items-center justify-center text-white shadow-xl shadow-blue-500/30 hover:scale-110 active:scale-95 transition-transform duration-200 relative ml-auto">
        <span class="absolute inset-0 rounded-full bg-blue-500 animate-ping opacity-20 pointer-events-none {{ $open ? 'hidden' : '' }}"></span>
        <i class="fas {{ $open ? 'fa-chevron-down text-lg' : 'fa-comment-dots text-xl' }} pointer-events-none"></i>
    </button>
</div>