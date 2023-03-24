<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24FieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_fields', function (Blueprint $table) {
           // $table->id();
            $table->unsignedBigInteger('ID')->primary();
            $table->string('VALUE');
            $table->string('ENTITY_ID');
            $table->string('FIELD_NAME');
            $table->unsignedBigInteger('FIELD_ID');

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
        Schema::dropIfExists('b24_fields');
    }
}
