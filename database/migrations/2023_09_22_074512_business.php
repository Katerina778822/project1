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
        Schema::create('business', function (Blueprint $table) {
            $table->unsignedBigInteger('ID')->primary();
            $table->string('name_')->default('')->nullable();
            $table->float('Type_');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('business');
    }
};
