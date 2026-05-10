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
        Schema::table('venues', function (Blueprint $table): void {
            $table->string('primary_color', 7)->default('#6366f1')->after('view_count');
            $table->string('logo_path')->nullable()->after('primary_color');
        });
    }

    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table): void {
            $table->dropColumn(['primary_color', 'logo_path']);
        });
    }
};
