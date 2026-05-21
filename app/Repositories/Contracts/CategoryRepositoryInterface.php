<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Category;

    public function findBySlug(string $slug): ?Category;

    public function save(array $data): Category;

    public function update(Category $category, array $data): Category;

    public function delete(Category $category): void;

    public function totalCount(): int;
}
