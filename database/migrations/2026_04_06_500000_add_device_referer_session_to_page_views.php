<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('device_type', 20)->default('desktop')->after('user_role');  // desktop | mobile | tablet
            $table->string('referer_host', 120)->nullable()->after('device_type');      // domaine référent (null = direct)
            $table->char('session_hash', 64)->nullable()->after('referer_host');        // hash(session_id)

            $table->index('device_type');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropIndex(['device_type']);
            $table->dropColumn(['device_type', 'referer_host', 'session_hash']);
        });
    }
};
