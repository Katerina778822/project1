<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB24UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_users', function (Blueprint $table) {
         //   $table->id();
            $table->unsignedBigInteger('ID')->primary();
            $table->boolean('ACTIVE');
            $table->string('NAME')->default('')->nullable();
            $table->string('LAST_NAME')->default('')->nullable();
            $table->string('VALUE')->default('')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('ID')->on('user');

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
        Schema::dropIfExists('b24_users');
    }
}
