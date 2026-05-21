<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categories,
    ) {}

    public function getAll(): Collection
    {
        return $this->categories->getAll();
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->categories->findBySlug($slug);
    }

    public function totalCount(): int
    {
        return $this->categories->totalCount();
    }
}
