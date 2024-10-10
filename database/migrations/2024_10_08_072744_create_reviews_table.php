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
        //database for rating and reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id'); //id auto increment
            $table->unsignedInteger('user_id'); //user id
            $table->unsignedInteger('doc_id'); //doctor id
            $table->unsignedInteger('ratings')->nullable(); //ratings
            $table->longText('reviews')->nullable(); //reviews
            $table->string('reviewed_by'); //reviewed by
            $table->string('status'); //status
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
