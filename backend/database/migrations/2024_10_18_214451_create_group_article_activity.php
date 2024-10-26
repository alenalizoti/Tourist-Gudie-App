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
        Schema::create('article_activity', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("article_id");
            $table->foreign("article_id")->references('id')->on('article');
            $table->unsignedBigInteger("activity_id");
            $table->foreign("activity_id")->references('id')->on('activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_activity');
    }
};
