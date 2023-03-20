<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('name',45)->nullable(false);
            $table->string('value',45)->nullable(false);
            $table->unsignedBigInteger('fid_id_catalog')->nullable(false);
            $table->foreign('fid_id_catalog')->references('id')->on('catalogs');
            $table->timestamp('createdAt')->nullable();    
            $table->timestamp('updatedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
}
