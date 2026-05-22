<?php

namespace App\Http\Controllers;

use App\Services\VenueService;
use App\Services\WikiService;
use Illuminate\View\View;

class WikiController extends Controller
{
    public function __construct(
        private WikiService $wiki,
        private VenueService $venues,
    ) {}

    public function index(): View
    {
        $grouped = $this->wiki->getGroupedArticles();

        return view('wiki.index', [
            'grouped' => $grouped,
            'categories' => $this->wiki->getActiveCategories($grouped),
            'tourUrl' => $this->resolveTourUrl(),
        ]);
    }

    public function show(string $slug): View
    {
        $article = $this->wiki->findBySlug($slug);

        if (! $article) {
            abort(404);
        }

        $grouped = $this->wiki->getGroupedArticles();

        return view('wiki.show', [
            'article' => $article,
            'categories' => $this->wiki->getActiveCategories($grouped),
            'grouped' => $grouped,
        ]);
    }

    private function resolveTourUrl(): string
    {
        $venue = $this->venues->getPublished()->first();

        return $venue ? route('tour', $venue->slug) : route('home');
    }
}
