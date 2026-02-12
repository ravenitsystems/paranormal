<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('county', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('state');
        });
    }
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('county');
        Schema::enableForeignKeyConstraints();
    }
};
