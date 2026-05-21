<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\VenueRepositoryInterface;
use App\Services\WikiService;
use Illuminate\Http\Response;
use Illuminate\View\View;

class WikiController extends Controller
{
    public function __construct(
        private WikiService $wiki,
        private VenueRepositoryInterface $venues,
    ) {}

    public function index(): View
    {
        return view('wiki.index', [
            'grouped' => $this->wiki->getGroupedArticles(),
            'categories' => $this->wiki->getActiveCategories(),
            'tourUrl' => $this->resolveTourUrl(),
        ]);
    }

    public function show(string $slug): View|Response
    {
        $article = $this->wiki->findBySlug($slug);

        if (! $article) {
            abort(404);
        }

        return view('wiki.show', [
            'article' => $article,
            'categories' => $this->wiki->getActiveCategories(),
            'grouped' => $this->wiki->getGroupedArticles(),
        ]);
    }

    private function resolveTourUrl(): string
    {
        $venue = $this->venues->allPublished()->first();

        return $venue ? route('tour', $venue->slug) : route('home');
    }
}
