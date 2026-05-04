<?php

namespace App\Http\Controllers;

use App\Models\PortfolioView;
use App\Models\User;

class PortfolioController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $portfolio = $user->portfolio;

        if (!$portfolio || !$portfolio->published) {
            abort(404);
        }

        $this->trackView($portfolio);

        return view('portfolio.public', compact('user', 'portfolio'));
    }

    private function trackView(\App\Models\Portfolio $portfolio): void
    {
        // Skip if the owner is viewing their own portfolio
        if (auth()->check() && auth()->id() === $portfolio->user_id) {
            return;
        }

        $ip = request()->ip();

        // One view per IP per 24 hours
        $key = "pv:{$portfolio->id}:{$ip}";
        if (cache()->has($key)) {
            return;
        }
        cache()->put($key, true, now()->addHours(24));

        PortfolioView::create([
            'portfolio_id' => $portfolio->id,
            'ip_address'   => $ip,
            'user_agent'   => substr(request()->userAgent() ?? '', 0, 500),
            'referer'      => substr(request()->header('referer') ?? '', 0, 500),
        ]);
    }
}
