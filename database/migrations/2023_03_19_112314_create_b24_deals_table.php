<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24DealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_deals', function (Blueprint $table) {
            $table->unsignedBigInteger('id1')->autoIncrement();
            $table->unsignedBigInteger('ID')->nullable();//b24 ID
            $table->unsignedBigInteger('ASSIGNED_BY_ID')->default(0); //user
            $table->unsignedBigInteger('COMPANY_ID')->default(0); //company
            $table->unsignedBigInteger('dealtype_id')->default(0); //deal type
            $table->string('TITLE')->default('');

            $table->char('CLOSED')->default('');
            $table->string('STAGE_ID')->default('');
            $table->string('CURRENCY_ID')->default('');
            $table->double('OPPORTUNITY')->default(0)->nullable();
            $table->string('COMMENTS')->default('')->nullable();
            $table->char('IS_RETURN_CUSTOMER')->default('')->nullable();;
            $table->timestamps();
            $table->string('STAGE_ID_BEFORE')->default('')->nullable(); // Результат работы со сделкой
            $table->string('UF_CRM_1545747379148')->default('')->nullable(); // Результат работы со сделкой
            $table->string('UF_CRM_5C20F23556A62')->default('')->nullable(); //  Канал продажи
            $table->string('UF_CRM_5BB6246DC30D8')->default('')->nullable(); //  Boost. Угода Генерация Джерело Лида
            $table->string('UF_CRM_1545811346080')->default('')->nullable(); //  Boost. Угода Генерация Бенефициар
            $table->string('UF_CRM_1564411704463')->default('')->nullable(); //  Boost. Конвертация. Угода.  СОСТОЯНИЕ
            $table->dateTime('UF_CRM_5CAB07390C964')->nullable()->default(null);//  Взял ЗАКАЗ. Дата
            $table->dateTime('UF_CRM_1540120643248')->default(null)->nullable(); //  Взял ПРОСЧЕТ.ДАТА
            $table->dateTime('UF_CRM_1545811274193')->default(null)->nullable(); //  Взял ДЕНЬГИ. Дата
            $table->dateTime('UF_CRM_1547732437301')->default(null)->nullable(); //  РЕЗУЛЬТАТ ДАТА
            $table->date('DATE_WIN')->default(null)->nullable(); //
            $table->dateTime('DATE_CREATE')->default(null)->nullable(); //
            $table->dateTime('DATE_MODIFY')->default(null)->nullable(); //
            $table->dateTime('CLOSEDATE')->default(null)->nullable(); //
            $table->string('UF_CRM_5C224D08961A9')->default('')->nullable(); //  ЛПР
            $table->string('CATEGORY_ID')->default('')->nullable(); //  напрямок
            $table->float('customer')->default('0')->nullable(); // тип покупателя (новый, постоянный и тд.)

            $table->foreign('ASSIGNED_BY_ID')->references('ID')->on('b24_users');
            $table->foreign('COMPANY_ID')->references('ID')->on('companies');
            $table->foreign('dealtype_id')->references('ID')->on('deal_types');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b24_deals');
    }
}
