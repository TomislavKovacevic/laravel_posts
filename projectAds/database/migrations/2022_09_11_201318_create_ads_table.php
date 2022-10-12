<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("body");
            $table->string("price");
            $table->string("image1")->nullable();
            $table->string("image2")->nullable();
            $table->string("image3")->nullable();;
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("category_id");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("category_id")->references("id")->on("categories"); // categories se je migracija za category
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
