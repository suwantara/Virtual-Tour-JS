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
        return view('wiki.index', [
            'sections' => $this->wiki->getSections(),
            'tourUrl' => $this->resolveTourUrl(),
        ]);
    }

    public function show(string $slug): View
    {
        $article = $this->wiki->findBySlug($slug);

        if (! $article) {
            abort(404);
        }

        $sections = $this->wiki->getSections();
        $adjacent = $this->wiki->getAdjacentArticles($article, $sections);

        return view('wiki.show', [
            'article' => $article,
            'sections' => $sections,
            'prev' => $adjacent['prev'],
            'next' => $adjacent['next'],
        ]);
    }

    private function resolveTourUrl(): string
    {
        $venue = $this->venues->getPublished()->first();

        return $venue ? route('tour', $venue->slug) : route('home');
    }
}
