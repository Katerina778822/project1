<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('NAME')->nullable()->default('');
            $table->string('LAST_NAME')->nullable()->default('');

            $table->unsignedBigInteger('ASSIGNED_BY_ID')->nullable()->default(0);
            $table->unsignedBigInteger('COMPANY_ID')->nullable()->default(0);

            $table->dateTime('DATE_CREATE')->nullable()->default(null);
            $table->dateTime('DATE_MODIFY')->nullable()->default(null);
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
        Schema::dropIfExists('b24_contacts');
    }
}
