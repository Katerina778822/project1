<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24RaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_raports', function (Blueprint $table) {
            $table->id();
            $table->integer('SUMM')->nullable()->default(0);
            $table->unsignedBigInteger('USER_ID')->nullable()->default(0);
            $table->unsignedBigInteger('COMPANY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('LEAD_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CONTACT_ID')->nullable()->default(0);
            $table->unsignedBigInteger('DEAL_ID')->nullable()->default(0);
            $table->unsignedBigInteger('TASK_ID')->nullable()->default(0);
            $table->unsignedBigInteger('RING_ID')->nullable()->default(0);
            $table->unsignedBigInteger('ACTIVITY_ID')->nullable()->default(0);
            $table->Integer('DEAL_TYPE')->nullable()->default(0);//4-новый; 3-Остывший; 2 - База; 1 - Клиент;
            $table->Integer('DEAL_STATUS')->nullable()->default(0);//4-выигрыш; 3-прогресс; 2 - перенос; 1 - отказ;
            $table->date('DATE')->nullable()->default('2023-01-01');
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
        Schema::dropIfExists('b24_raports');
    }
}
