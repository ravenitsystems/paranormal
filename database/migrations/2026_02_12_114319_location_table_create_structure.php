<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->bigInteger('lon');
            $table->bigInteger('lat');
            $table->unsignedBigInteger('town_id');
            $table->foreign('town_id')->references('id')->on('town');
        });
    }
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('location');
        Schema::enableForeignKeyConstraints();
    }
};
