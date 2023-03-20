<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('value',45)->nullable(false);
            $table->string('url',256)->nullable(false)->unique();
            $table->integer('branch_progress_good')->default(0);
            $table->unsignedBigInteger('fid_id_node')->nullable(false);
            $table->foreign('fid_id_node')->references('id')->on('nodes');
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
        Schema::dropIfExists('catalogs');
    }
}
