<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24LeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_leads', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->string('TITLE')->nullable()->default('');
            $table->string('NAME')->nullable()->default('');
            $table->string('LAST_NAME')->nullable()->default('');
            $table->string('SOURCE_ID')->nullable()->default('');
            $table->string('STATUS_ID')->nullable()->default('');
            $table->string('COMMENTS')->nullable()->default('');
            $table->string('ADDRESS')->nullable()->default('');
            $table->string('UTM_SOURCE')->nullable()->default('');
            $table->string('UTM_MEDIUM')->nullable()->default('');
            $table->string('UTM_CAMPAIGN')->nullable()->default('');        
            $table->string('UTM_CONTENT')->nullable()->default('');
            $table->string('UTM_TERM')->nullable()->default('');
            $table->string('CURRENCY_ID')->nullable()->default('');
            $table->string('PHONE')->nullable()->default('');

            $table->double('OPPORTUNITY')->nullable()->default(0);
            $table->unsignedBigInteger('COMPANY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CONTACT_ID')->nullable()->default(0);
            $table->unsignedBigInteger('ASSIGNED_BY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CREATED_BY_ID')->nullable()->default(0);
            $table->dateTime('DATE_CREATE')->nullable()->default(null);
            $table->dateTime('DATE_CLOSED')->nullable()->default(null);
            $table->dateTime('DATE_MODIFY')->nullable()->default(null);

            $table->foreign('ASSIGNED_BY_ID')->references('ID')->on('b24_users');
            $table->foreign('CREATED_BY_ID')->references('ID')->on('b24_users');
        
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
        Schema::dropIfExists('b24_leads');
    }
}
