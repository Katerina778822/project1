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
        Schema::create('branch_guide', function (Blueprint $table) {
            $table->unsignedBigInteger('ID')->primary();
            $table->unsignedBigInteger('branch_id');
            $table->float('customer_type');
            $table->unsignedBigInteger('guide_id');

            $table->foreign('guide_id')->references('ID')->on('guide');
            $table->foreign('branch_id')->references('ID')->on('branch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('branch_guide');
    }
};
