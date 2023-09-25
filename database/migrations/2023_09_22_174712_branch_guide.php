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
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->float('customer_type');
            $table->unsignedBigInteger('guide_id');

            $table->foreign('guide_id')->references('id')->on('guides');
            $table->foreign('branch_id')->references('id')->on('branches');
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
