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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_id')->nullable(false);
            $table->unsignedBigInteger('typeTask')->nullable(false);
            $table->text('name')->nullable(true);
            $table->text('description')->nullable();
            $table->dateTime('deadline')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('deal_id')->references('id1')->on('b24_deals');
            $table->foreign('typeTask')->references('id')->on('task_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
