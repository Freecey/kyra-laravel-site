<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_message_id')
                  ->constrained('contact_messages')
                  ->cascadeOnDelete();
            $table->string('subject');
            $table->text('body');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('message_reply_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_reply_id')
                  ->constrained('message_replies')
                  ->cascadeOnDelete();
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_reply_attachments');
        Schema::dropIfExists('message_replies');
    }
};
