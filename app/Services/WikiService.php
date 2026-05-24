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

    /**
     * Ordered sections: each element is ['category' => WikiCategory, 'articles' => Collection<int, WikiArticle>].
     *
     * @return Collection<int, array{category: WikiCategory, articles: Collection<int, WikiArticle>}>
     */
    public function getSections(): Collection
    {
        $grouped = $this->getGroupedArticles();

        return $this->getActiveCategories($grouped)
            ->map(fn (WikiCategory $cat): array => [
                'category' => $cat,
                'articles' => $grouped->get($cat->id, collect()),
            ]);
    }

    /**
     * @param  Collection<int, array{category: WikiCategory, articles: Collection<int, WikiArticle>}>  $sections
     * @return array{prev: ?WikiArticle, next: ?WikiArticle}
     */
    public function getAdjacentArticles(WikiArticle $article, Collection $sections): array
    {
        $flat = $sections->flatMap(fn (array $section): array => $section['articles']->all());
        $idx = $flat->search(fn (WikiArticle $a): bool => $a->slug === $article->slug);

        return [
            'prev' => $idx > 0 ? $flat->get($idx - 1) : null,
            'next' => $flat->get($idx + 1),
        ];
    }
}
