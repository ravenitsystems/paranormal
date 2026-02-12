<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('code_3', 3);
            $table->string('code_2', 2);
        });
    }
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('country');
        Schema::enableForeignKeyConstraints();
    }
};
