<?php

namespace App\Services;

use App\Enums\WikiCategory;
use App\Models\WikiArticle;
use App\Repositories\Contracts\WikiArticleRepositoryInterface;
use Illuminate\Support\Collection;

class WikiService
{
    public function __construct(
        private WikiArticleRepositoryInterface $articles,
    ) {}

    /**
     * Articles grouped by category for the index page.
     *
     * @return Collection<string, Collection<int, WikiArticle>>
     */
    public function getGroupedArticles(): Collection
    {
        return $this->articles->allPublished()
            ->groupBy(fn (WikiArticle $article): string => $article->category->value);
    }

    public function findBySlug(string $slug): ?WikiArticle
    {
        return $this->articles->findBySlug($slug);
    }

    /** @return array<int, WikiCategory> Ordered list of categories that have at least one published article */
    public function getActiveCategories(): array
    {
        $populated = $this->articles->allPublished()
            ->pluck('category')
            ->unique()
            ->map(fn ($c): string => $c->value)
            ->flip();

        return array_values(
            array_filter(WikiCategory::cases(), fn (WikiCategory $c): bool => isset($populated[$c->value]))
        );
    }
}
