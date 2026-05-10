<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->float('initial_yaw')->default(0);
            $table->float('initial_pitch')->default(0);
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->foreignId('cover_scene_id')->nullable()->after('is_published')->constrained('scenes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropForeign(['cover_scene_id']);
            $table->dropColumn('cover_scene_id');
        });

        Schema::dropIfExists('scenes');
    }
};
