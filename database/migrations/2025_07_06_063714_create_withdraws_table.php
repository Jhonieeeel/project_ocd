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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string("ris")->nullable();
            $table->integer('requested_quantity');
            $table->foreignId("requested_by")->nullable()->constrained('users');
            $table->foreignId("approved_by")->nullable()->constrained('users');
            $table->foreignId("issued_by")->nullable()->constrained('users');
            $table->foreignId("received_by")->nullable()->constrained('users');
            $table->date("approved_date")->nullable();
            $table->date("requested_date")->nullable();
            $table->date("received_date")->nullable();
            $table->date("issued_date")->nullable();
            $table->foreignId("stock_id")->constrained()->cascadeOnDelete();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
