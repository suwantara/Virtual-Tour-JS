<?php

namespace App\Models;

use App\Enums\WikiCategory;
use Database\Factories\WikiArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'title', 'category', 'excerpt', 'content', 'order', 'is_published'])]
class WikiArticle extends Model
{
    /** @use HasFactory<WikiArticleFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'category' => WikiCategory::class,
            'is_published' => 'boolean',
            'order' => 'integer',
        ];
    }
}
