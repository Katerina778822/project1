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
            $table->id();
            $table->unsignedBigInteger('responsibleId')->nullable()->default(0);
            $table->bigInteger('status')->nullable()->default(0);
            $table->bigInteger('timeEstimate')->nullable()->default(0);
            $table->unsignedBigInteger('UF_CRM_TASK_LEAD')->nullable()->default(0);
            $table->unsignedBigInteger('UF_CRM_TASK_CONTACT')->nullable()->default(0);
            $table->unsignedBigInteger('UF_CRM_TASK_DEAL')->nullable()->default(0);
            $table->unsignedBigInteger('UF_CRM_TASK_COMPANY')->nullable()->default(0);

            $table->text('title')->nullable()->default('');
            $table->text('description')->nullable()->default('');
            $table->dateTime('closedDate')->nullable()->default(null);
            $table->dateTime('createdDate')->nullable()->default(null);
            $table->dateTime('deadline')->nullable()->default(null);
            $table->dateTime('dateStart')->nullable()->default(null);
            $table->dateTime('changedDate')->nullable()->default(null);
            $table->timestamps();
            // $table->foreign('UF_CRM_TASK_DEAL')->references('ID')->on('b24_deals');
            //$table->foreign('UF_CRM_TASK_COMPANY')->references('ID')->on('companies');
            $table->foreign('responsibleId')->references('ID')->on('b24_users');
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
