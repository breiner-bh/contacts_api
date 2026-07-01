<?php

use GuzzleHttp\Promise\Create;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::Create( 'concacts' ,function(Blueprint $table){
            $table->id();
            $table->string('name')->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->string('phone_number')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
