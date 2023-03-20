<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('name',120)->nullable(false);
            $table->string('url',200)->nullable(false);
            $table->unsignedBigInteger('fid_id_catalog')->nullable(false);
            $table->foreign('fid_id_catalog')->references('id')->on('catalogs');
            $table->string('art',100)->nullable(true);
            $table->text('descripttxt',7000)->nullable(true);
            $table->text('descripthtml',10000)->nullable(true);
            $table->string('fotos',700)->nullable(true);
            $table->string('videos',400)->nullable(true);
            $table->string('charact',3000)->nullable(true);
            $table->string('complect',1000)->nullable(true);
            $table->string('price',80)->nullable(true);
            $table->string('store',80)->nullable(true);
            $table->string('f1',80)->nullable(true);
            $table->string('f2',80)->nullable(true);
            $table->string('f3',80)->nullable(true);
            $table->string('f4',80)->nullable(true);
            $table->string('f5',80)->nullable(true);
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
        Schema::dropIfExists('goods');
    }
}
