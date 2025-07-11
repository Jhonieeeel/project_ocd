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
        Schema::create('approved_withdraws', function (Blueprint $table) {
            $table->id();
            $table->integer('printed_times')->default(1);
            $table->foreignId("withdraw_id")->constrained()->noActionOnDelete();
            $table->string('filepath')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_withdraws');
    }
};
