<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('town', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->unsignedBigInteger('county_id');
            $table->foreign('county_id')->references('id')->on('county');
        });
    }
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('town');
        Schema::enableForeignKeyConstraints();
    }
};
