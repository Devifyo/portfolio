<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Dev Portfolio | Full Stack & AI Engineer')] class extends Component
{
    //
};
?>

<div>
    <x-sections.hero />
    <x-sections.stats />
    <x-sections.tech-stack />
    <x-sections.experience />
    <x-sections.featured-work />
    <livewire:contact />
    <x-sections.footer />
</div>
