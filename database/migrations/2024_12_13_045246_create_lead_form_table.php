<?php

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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->string('name');
            $table->string('phone');
            $table->string('city');
            $table->string('state');
            $table->string('source')->nullable();
            $table->string('lead_tag')->nullable();
            $table->integer('qualification_status')->nullable();
            $table->string('rating')->nullable();
            $table->longText('note')->nullable();
            $table->string('note_strike_first')->nullable();
            $table->string('action')->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('leads_colors', function (Blueprint $table) {
            $table->id();
            $table->string('column_key');
            $table->string('color');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('leads_colors');
    }
};
