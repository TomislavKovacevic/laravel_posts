<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**kreirana migracija u terminalu
     * php artisan make:migration add_views_to_ads
     * nakon popunjene schema i funkcije down() uraditi
     * php artisan migrate
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->integer("views")->after("price")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn("views");
        });
    }
};
