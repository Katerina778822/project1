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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->nullable();
            $table->float('Type');
        });

        Schema::table('users',function (Blueprint $table) {
            $table->unsignedBigInteger('business_id');//foreign key
            $table->foreign('business_id')->references('id')->on('businesses');
        });
       
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
