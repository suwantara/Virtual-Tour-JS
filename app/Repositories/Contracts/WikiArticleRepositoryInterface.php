<?php

namespace App\Repositories\Contracts;

use App\Models\WikiArticle;
use App\Models\WikiCategory;
use Illuminate\Support\Collection;

interface WikiArticleRepositoryInterface
{
    /** @return Collection<int, WikiArticle> */
    public function allPublished(): Collection;

    /** @return Collection<int, WikiArticle> */
    public function publishedByCategory(WikiCategory $category): Collection;

    public function findBySlug(string $slug): ?WikiArticle;
}
