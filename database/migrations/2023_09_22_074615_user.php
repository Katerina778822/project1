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
        Schema::create('user', function (Blueprint $table) {
            $table->unsignedBigInteger('ID')->primary();
            $table->string('contact_type')->default('')->nullable();
            $table->dateTime('contact_date');
            $table->unsignedBigInteger('business_ID');

            $table->foreign('business_ID')->references('ID')->on('business');

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
