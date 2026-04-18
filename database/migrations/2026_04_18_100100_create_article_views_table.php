<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_blog_id')->constrained('food_blogs')->cascadeOnDelete();
            $table->string('session_id');
            $table->date('view_date');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->unique(['food_blog_id', 'session_id', 'view_date']);
            $table->index(['food_blog_id', 'view_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
