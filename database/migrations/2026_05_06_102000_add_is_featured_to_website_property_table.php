<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_property', function (Blueprint $table): void {
            $table->boolean('is_featured')->default(false)->after('is_published');
            $table->index(['is_published', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::table('website_property', function (Blueprint $table): void {
            $table->dropIndex(['is_published', 'is_featured']);
            $table->dropColumn('is_featured');
        });
    }
};
