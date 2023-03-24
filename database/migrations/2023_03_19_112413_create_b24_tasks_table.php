<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_tasks', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->bigInteger('STAGE_ID')->nullable()->default(0);
            $table->bigInteger('PARENT_ID')->nullable()->default(0);
            $table->bigInteger('GROUP_ID')->nullable()->default(0);
            $table->bigInteger('RESPONSIBLE_ID')->nullable()->default(0);
            $table->bigInteger('REAL_STATUS')->nullable()->default(0);
            $table->bigInteger('STATUS')->nullable()->default(0);
            $table->bigInteger('FORUM_ID')->nullable()->default(0);
            $table->bigInteger('FORUM_TOPIC_ID')->nullable()->default(0);
            



            $table->text('DESCRIPTION')->nullable()->default('');
            $table->string('RESPONSIBLE_NAME')->nullable()->default('');
            $table->string('RESPONSIBLE_LAST_NAME')->nullable()->default('');
            $table->string('GUID')->nullable()->default('');
           // $table->string('')->nullable()->default('');
            
            $table->dateTime('ACTIVITY_DATE')->nullable()->default(null);
            $table->dateTime('CLOSED_DATE')->nullable()->default(null);
            $table->dateTime('CREATED_DATE')->nullable()->default(null);
            $table->dateTime('DEADLINE')->nullable()->default(null);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b24_tasks');
    }
}
