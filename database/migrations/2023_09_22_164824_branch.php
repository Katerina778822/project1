<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('branch', function (Blueprint $table) {
            $table->unsignedBigInteger('ID')->primary();
            $table->string('name_business')->default('')->nullable();
            $table->unsignedBigInteger('guide_id');

            $table->foreign('guide_id')->references('ID')->on('branch_guide');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('branch');
    }
};
