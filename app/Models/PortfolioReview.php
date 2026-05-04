<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioReview extends Model
{
    protected $fillable = [
        'portfolio_id', 'name', 'rating', 'feedback',
        'country', 'country_code', 'city', 'ip_address',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
