<?php

namespace App\Services;

use App\Models\WikiArticle;
use App\Models\WikiCategory;
use App\Repositories\Contracts\WikiArticleRepositoryInterface;
use Illuminate\Support\Collection;

class WikiService
{
    public function __construct(
        private WikiArticleRepositoryInterface $articles,
    ) {}

    /**
     * Articles grouped by wiki_category_id for the index/show pages.
     *
     * @return Collection<int, Collection<int, WikiArticle>>
     */
    public function getGroupedArticles(): Collection
    {
        return $this->articles->allPublished()
            ->groupBy(fn (WikiArticle $article): int => $article->wiki_category_id);
    }

    public function findBySlug(string $slug): ?WikiArticle
    {
        return $this->articles->findBySlug($slug);
    }

    /**
     * Ordered list of WikiCategory models that have at least one published article.
     * Extracts from already-eager-loaded relationships — no extra query.
     *
     * @param  Collection<int, Collection<int, WikiArticle>>  $grouped
     * @return Collection<int, WikiCategory>
     */
    public function getActiveCategories(Collection $grouped): Collection
    {
        return $grouped
            ->map(fn (Collection $articles): ?WikiCategory => $articles->first()?->wikiCategory)
            ->filter()
            ->sortBy('order')
            ->values();
    }
}
