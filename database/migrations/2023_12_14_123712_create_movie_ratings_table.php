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
        Schema::create('movie_rating', function (Blueprint $table) {
            $table->id();
            $table->integer('value')->nullable(false);
            $table->string('comment')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('movie_id');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->unsignedBigInteger('streaming_id');
            $table->foreign('streaming_id')->references('id')->on('streamings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_rating');
    }
};
