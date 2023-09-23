<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->unsignedBigInteger('ID')->primary();
            $table->unsignedBigInteger('typeEvent');
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('branch_id');

            $table->foreign('typeEvent')->references('ID')->on('stage');
            $table->foreign('deal_id')->references('ID')->on('b24_deals');
            $table->foreign('branch_id')->references('ID')->on('branches');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
