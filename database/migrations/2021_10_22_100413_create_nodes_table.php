<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
        //    $table->timestamps();
            $table->string('name',45)->nullable(false);
            $table->string('url',256)->nullable(false);
            $table->string('node_paginat_pattern',45)->nullable()->default(0);
            $table->string('login',45)->nullable()->default(0);
            $table->string('pass',45)->nullable()->default(0);
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
        Schema::dropIfExists('nodes');
    }
}
