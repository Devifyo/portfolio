<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id', 'hero_name', 'hero_title', 'hero_bio', 'hero_available',
        'hero_avatar', 'hero_media_type', 'hero_video', 'hero_github', 'hero_linkedin',
        'stat_startups', 'stat_years', 'stat_projects',
        'tech_stack', 'experience', 'projects',
        'contact_email', 'contact_location', 'contact_phone', 'contact_calendly',
        'contact_upwork', 'contact_fiverr', 'contact_freelancer', 'published',
    ];

    protected $casts = [
        'tech_stack'     => 'array',
        'experience'     => 'array',
        'projects'       => 'array',
        'hero_available' => 'boolean',
        'published'      => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function views(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PortfolioView::class);
    }
}
