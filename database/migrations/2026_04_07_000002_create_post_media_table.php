<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_post_id');
            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('alt')->nullable();
            $table->timestamps();

            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->cascadeOnDelete();
        });

        // Now add the FK from blog_posts to post_media (post_media table now exists)
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->foreign('featured_media_id')->references('id')->on('post_media')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign(['featured_media_id']);
        });
        Schema::dropIfExists('post_media');
    }
};
