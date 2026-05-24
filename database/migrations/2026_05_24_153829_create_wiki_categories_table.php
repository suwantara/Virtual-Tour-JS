<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiki_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        $now = now();
        $defaults = [
            ['slug' => 'sejarah',   'name' => 'Sejarah & Latar Belakang', 'icon' => 'heroicon-o-book-open',           'order' => 0],
            ['slug' => 'pelinggih', 'name' => 'Pelinggih',                'icon' => 'heroicon-o-building-library',    'order' => 1],
            ['slug' => 'ritual',    'name' => 'Ritual & Upacara',         'icon' => 'heroicon-o-sparkles',            'order' => 2],
            ['slug' => 'tokoh',     'name' => 'Tokoh',                    'icon' => 'heroicon-o-user',                'order' => 3],
            ['slug' => 'glosarium', 'name' => 'Glosarium',               'icon' => 'heroicon-o-language',            'order' => 4],
            ['slug' => 'info',      'name' => 'Informasi Umum',          'icon' => 'heroicon-o-information-circle',  'order' => 5],
        ];

        foreach ($defaults as $row) {
            DB::table('wiki_categories')->insert($row + ['created_at' => $now, 'updated_at' => $now]);
        }

        Schema::table('wiki_articles', function (Blueprint $table) {
            $table->foreignId('wiki_category_id')
                ->nullable()
                ->after('slug')
                ->constrained('wiki_categories')
                ->restrictOnDelete();
        });

        // Migrate existing rows: match old string slug → new FK id
        DB::table('wiki_articles')->get()->each(function (object $article): void {
            $cat = DB::table('wiki_categories')->where('slug', $article->category)->first();
            if ($cat) {
                DB::table('wiki_articles')->where('id', $article->id)->update(['wiki_category_id' => $cat->id]);
            }
        });

        Schema::table('wiki_articles', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('wiki_articles', function (Blueprint $table) {
            $table->string('category')->default('info')->after('slug');
        });

        DB::table('wiki_articles')->get()->each(function (object $article): void {
            $cat = DB::table('wiki_categories')->where('id', $article->wiki_category_id)->first();
            if ($cat) {
                DB::table('wiki_articles')->where('id', $article->id)->update(['category' => $cat->slug]);
            }
        });

        Schema::table('wiki_articles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('wiki_category_id');
        });

        Schema::dropIfExists('wiki_categories');
    }
};
