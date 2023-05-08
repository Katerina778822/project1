<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24Activity2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_activity2', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->bigInteger('OWNER_ID')->nullable()->default(0);
            $table->bigInteger('OWNER_TYPE_ID')->nullable()->default(0);
            $table->bigInteger('ASSOCIATED_ENTITY_ID')->nullable()->default(0);
            $table->bigInteger('AUTHOR_ID')->nullable()->default(0);
            $table->bigInteger('EDITOR_ID')->nullable()->default(0);

            $table->string('PROVIDER_ID')->nullable()->default('');
            $table->string('PROVIDER_TYPE_ID')->nullable()->default('');
            $table->string('SUBJECT')->nullable()->default('');
            $table->string('DESCRIPTION')->nullable()->default('');
            $table->char('COMPLETED')->nullable()->default('');

            $table->unsignedBigInteger('ASSIGNED_BY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('COMPANY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('LEAD_ID')->nullable()->default(0);
            $table->unsignedBigInteger('DEAL_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CONTACT_ID')->nullable()->default(0);

            $table->dateTime('CREATED')->nullable()->default(null);
            $table->dateTime('LAST_UPDATED')->nullable()->default(null);
            $table->dateTime('START_TIME')->nullable()->default(null);
            $table->dateTime('END_TIME')->nullable()->default(null);
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
        Schema::dropIfExists('b24_activity2s');
    }
}
