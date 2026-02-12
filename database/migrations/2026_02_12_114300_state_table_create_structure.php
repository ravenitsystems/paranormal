<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('state', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('country');
        });
    }
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('state');
        Schema::enableForeignKeyConstraints();
    }
};
