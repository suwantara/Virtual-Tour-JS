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
        Schema::table('scenes', function (Blueprint $table) {
            $table->string('local_name')->nullable()->after('name');
            $table->string('era')->nullable()->after('description');
            $table->string('ritual_function')->nullable()->after('era');
            $table->string('material')->nullable()->after('ritual_function');
        });
    }

    public function down(): void
    {
        Schema::table('scenes', function (Blueprint $table) {
            $table->dropColumn(['local_name', 'era', 'ritual_function', 'material']);
        });
    }
};
