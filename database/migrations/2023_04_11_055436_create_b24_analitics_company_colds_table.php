<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_analitics_company_colds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable()->default(0);
            $table->unsignedBigInteger('ring_id')->nullable()->default(0);
            $table->unsignedBigInteger('task_id')->nullable()->default(0);
            $table->unsignedBigInteger('deal_id')->nullable()->default(0);
            $table->unsignedBigInteger('ringContact_id')->nullable()->default(0);
            $table->date('check_date')->nullable()->default('2023-01-01');
            $table->date('since_date')->nullable()->default('2023-01-01');
            $table->foreign('company_id')->references('ID')->on('companies');

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b24_analitics_company_colds');
    }
};
