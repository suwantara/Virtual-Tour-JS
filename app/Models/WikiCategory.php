<?php

namespace App\Models;

use Database\Factories\WikiCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'name', 'icon', 'order'])]
class WikiCategory extends Model
{
    /** @use HasFactory<WikiCategoryFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /** @return HasMany<WikiArticle, $this> */
    public function articles(): HasMany
    {
        return $this->hasMany(WikiArticle::class);
    }
}
