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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->string('name');
            $table->string('id_card');
            $table->string('phone');
            $table->string('product_id')->nullable();
            // $table->string('q1');
            // $table->string('q2');
            // $table->string('q3');
            // $table->string('q4');
            // $table->string('q5');
            // $table->string('q6');
            // $table->string('q7');
            // $table->string('q8');
            // $table->string('q9');
            // $table->string('q10');
            // $table->string('q10');
            // $table->string('q12');
            // $table->string('q13');
            $table->json('answers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
