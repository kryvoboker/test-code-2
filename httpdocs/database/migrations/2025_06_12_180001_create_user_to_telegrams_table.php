<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('user_to_telegrams', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table
                ->string('chat_id')
                ->unique();
            $table
                ->string('username')
                ->nullable();
            $table
                ->string('nickname')
                ->nullable();
            $table
                ->string('language_code', 10)
                ->default('en')
                ->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('user_to_telegrams');
    }
};
