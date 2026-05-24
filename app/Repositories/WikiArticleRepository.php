<?php

namespace App\Repositories;

use App\Models\WikiArticle;
use App\Models\WikiCategory;
use App\Repositories\Contracts\WikiArticleRepositoryInterface;
use Illuminate\Support\Collection;

class WikiArticleRepository implements WikiArticleRepositoryInterface
{
    public function allPublished(): Collection
    {
        return WikiArticle::with('wikiCategory')
            ->where('is_published', true)
            ->orderBy('wiki_category_id')
            ->orderBy('order')
            ->get();
    }

    public function publishedByCategory(WikiCategory $category): Collection
    {
        return WikiArticle::with('wikiCategory')
            ->where('is_published', true)
            ->where('wiki_category_id', $category->id)
            ->orderBy('order')
            ->get();
    }

    public function findBySlug(string $slug): ?WikiArticle
    {
        return WikiArticle::with('wikiCategory')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }
}
