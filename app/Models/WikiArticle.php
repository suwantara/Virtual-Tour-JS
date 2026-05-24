<?php

namespace App\Models;

use Database\Factories\WikiArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['slug', 'title', 'wiki_category_id', 'excerpt', 'content', 'order', 'is_published'])]
class WikiArticle extends Model
{
    /** @use HasFactory<WikiArticleFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'wiki_category_id' => 'integer',
            'is_published' => 'boolean',
            'order' => 'integer',
        ];
    }

    /** @return BelongsTo<WikiCategory, $this> */
    public function wikiCategory(): BelongsTo
    {
        return $this->belongsTo(WikiCategory::class);
    }
}
