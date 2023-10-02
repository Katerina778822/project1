<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24AnaliticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     // AIM   legend description
     //1 -
     //2 -
     //3 -
     //3377 -  cron.php update ALL DATA time
     //3388 -  agenda create time
     //4477 -    cron.php RAPORT update time
     //4488 -     RAPORT create time
     //4555 -     Error - deal without company
     //4554 -     Error - contact without company
     //4553 -     Error - other RAPORT creating error
//
    public function up()
    {
        Schema::create('b24_analitics', function (Blueprint $table) { //halp table
            $table->id();
            $table->unsignedBigInteger('AIM');// id for different solutions (tasks or aims)
            $table->unsignedBigInteger('id_item')->nullable()->default(0);
            $table->unsignedBigInteger('big_int1')->nullable()->default(0);
            $table->unsignedBigInteger('big_int2')->nullable()->default(0);
            $table->unsignedBigInteger('big_int3')->nullable()->default(0);
            $table->unsignedBigInteger('big_int4')->nullable()->default(0);
            $table->unsignedBigInteger('big_int5')->nullable()->default(0);
            $table->string('string1')->nullable()->default('');
            $table->string('string2')->nullable()->default('');
            $table->string('string3')->nullable()->default('');
            $table->string('string4')->nullable()->default('');
            $table->string('string5')->nullable()->default('');
            $table->double('double1')->nullable()->default(0);
            $table->double('double2')->nullable()->default(0);
            $table->double('double3')->nullable()->default(0);
            $table->double('double4')->nullable()->default(0);
            $table->double('double5')->nullable()->default(0);
            $table->text('text1')->nullable();
            $table->text('text2')->nullable();
            $table->text('text3')->nullable();
            $table->dateTime('date1')->nullable()->default(null);
            $table->dateTime('date2')->nullable()->default(null);
            $table->dateTime('date3')->nullable()->default(null);
            $table->dateTime('date4')->nullable()->default(null);
            $table->dateTime('date5')->nullable()->default(null);
            $table->dateTime('date6')->nullable()->default(null);
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
        Schema::dropIfExists('b24_analitics');
    }
}
