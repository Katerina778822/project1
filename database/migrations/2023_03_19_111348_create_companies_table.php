<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
          //  $table->id();
            $table->unsignedBigInteger('ID')->primary();
            $table->unsignedBigInteger('B24Deal_id');
            $table->unsignedBigInteger('B24Task_id');
            $table->unsignedBigInteger('B24Ring_id');
            $table->unsignedBigInteger('B24Userx`_id');
            $table->unsignedBigInteger('ASSIGNED_BY_ID');
            $table->unsignedBigInteger('LAST_ACTIVITY_BY');
            
            $table->string('TITLE');
            $table->string('UF_CRM_1540465145514');//СТАТУС Клиента
            $table->string('UF_CRM_1540121191354');//Развоз/Украина - День развоза
            $table->string('UF_CRM_5DBAA9FFCC357');//Активная сделка
            $table->unsignedBigInteger('UF_CRM_1597826997473');//ID последней сделки
            $table->string('COMPANY_TYPE');//Тип контакту
           // $table->string('UF_CRM_1540121191354');//

            $table->dateTime('DATE_CREATE');
            $table->dateTime('DATE_MODIFY');
            $table->dateTime('LAST_ACTIVITY_TIME');

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
        Schema::dropIfExists('companies');
    }
}
