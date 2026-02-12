<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location_country', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->string('name', 64);
            $table->string('code', 4);
        });

        Schema::create('location_state', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->string('name', 64);
            $table->bigInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('location_country');
        });

        Schema::create('location_county', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->string('name', 64);
            $table->bigInteger('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('location_state');
        });

        Schema::create('location_town', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->string('name', 64);
            $table->bigInteger('county_id')->unsigned();
            $table->foreign('county_id')->references('id')->on('location_county');
        });

        Schema::create('location_exact', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->bigInteger('longitude');
            $table->bigInteger('latitude');
            $table->bigInteger('town_id')->unsigned();
            $table->foreign('town_id')->references('id')->on('location_town');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('location_country');
        Schema::dropIfExists('location_state');
        Schema::dropIfExists('location_county');
        Schema::dropIfExists('location_town');
        Schema::dropIfExists('location_exact');
        Schema::enableForeignKeyConstraints();
    }
};
