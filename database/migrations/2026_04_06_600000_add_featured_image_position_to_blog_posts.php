<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->enum('featured_image_position', ['top', 'top-center', 'center', 'center-bottom', 'bottom'])
                  ->default('center')
                  ->after('featured_media_id');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('featured_image_position');
        });
    }
};
