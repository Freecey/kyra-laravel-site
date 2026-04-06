<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500);
            $table->string('route_name', 100)->nullable();
            $table->string('user_role', 20)->default('guest'); // guest, member, admin
            $table->char('ip_hash', 64);                       // sha256(IP) — no raw IP stored
            $table->date('viewed_on');
            $table->timestamps();

            $table->index('viewed_on');
            $table->index('path');
            $table->index('user_role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
