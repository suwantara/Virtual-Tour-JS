<?php

namespace App\Repositories;

use App\Enums\WikiCategory;
use App\Models\WikiArticle;
use App\Repositories\Contracts\WikiArticleRepositoryInterface;
use Illuminate\Support\Collection;

class WikiArticleRepository implements WikiArticleRepositoryInterface
{
    public function allPublished(): Collection
    {
        return WikiArticle::where('is_published', true)
            ->orderBy('category')
            ->orderBy('order')
            ->get();
    }

    public function publishedByCategory(WikiCategory $category): Collection
    {
        return WikiArticle::where('is_published', true)
            ->where('category', $category)
            ->orderBy('order')
            ->get();
    }

    public function findBySlug(string $slug): ?WikiArticle
    {
        return WikiArticle::where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }
}
