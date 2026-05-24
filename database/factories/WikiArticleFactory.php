<?php

namespace Database\Factories;

use App\Models\WikiArticle;
use App\Models\WikiCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<WikiArticle>
 */
class WikiArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(4, false);

        return [
            'slug' => Str::slug($title).'-'.$this->faker->unique()->randomNumber(4),
            'title' => $title,
            'wiki_category_id' => WikiCategory::factory(),
            'excerpt' => $this->faker->optional()->paragraph(),
            'content' => '<p>'.$this->faker->paragraphs(3, true).'</p>',
            'order' => $this->faker->numberBetween(0, 100),
            'is_published' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(['is_published' => false]);
    }
}
