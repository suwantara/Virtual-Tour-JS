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
        Schema::create('hotspots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scene_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['scene_link', 'info', 'url', 'media']);
            $table->string('label');
            $table->text('description')->nullable();
            $table->float('pitch')->default(0);
            $table->float('yaw')->default(0);
            $table->foreignId('target_scene_id')->nullable()->constrained('scenes')->nullOnDelete();
            $table->string('url')->nullable();
            $table->string('media_url')->nullable();
            $table->enum('media_type', ['video', 'audio', 'image'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspots');
    }
};
