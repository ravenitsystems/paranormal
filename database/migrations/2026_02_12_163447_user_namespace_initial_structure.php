<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('email', 128);
            $table->string('password', 64);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_editor')->default(false);
            $table->boolean('is_author')->default(false);
            $table->bigInteger('site_input_count')->default(0);
            $table->bigInteger('story_input_count')->default(0);
            $table->bigInteger('review_input_count')->default(0);
            $table->bigInteger('comment_input_count')->default(0);
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user');
        Schema::enableForeignKeyConstraints();
    }
};
