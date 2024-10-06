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
        Schema::table('article_views', function (Blueprint $table) {
            $table->dropForeign(['articles_id']);
            $table->dropForeign(['users_id']);
            $table->dropUnique('article_views_articles_id_users_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            $table->unique(['articles_id', 'users_id']);
            $table->foreign('articles_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
