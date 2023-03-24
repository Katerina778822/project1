<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24RingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_rings', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('ID')->primary();
            $table->string('CALL_ID')->nullable()->default('');
            $table->string('PHONE_NUMBER')->nullable()->default('');
            $table->string('CALL_CATEGORY')->nullable()->default('');
            $table->string('CRM_ENTITY_TYPE')->nullable()->default('');
            $table->text('CALL_RECORD_URL')->nullable()->default('');
            $table->string('CALL_FAILED_REASON')->nullable()->default('');
            $table->unsignedBigInteger('PORTAL_USER_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CRM_ENTITY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CALL_DURATION')->nullable()->default(0);
            $table->unsignedBigInteger('CRM_ACTIVITY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('CALL_TYPE')->nullable()->default(0);
            $table->unsignedBigInteger('RECORD_FILE_ID')->nullable()->default(0);
            $table->dateTime('CALL_START_DATE')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b24_rings');
    }
}
