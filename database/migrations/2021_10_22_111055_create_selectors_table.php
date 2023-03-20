<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selectors', function (Blueprint $table) {
            $table->id();
            $table->string('name',45)->nullable(false);
            $table->string('value',145)->nullable(true);
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
        Schema::dropIfExists('selectors');
    }
}
