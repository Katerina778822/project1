<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guide', function (Blueprint $table) {
            $table->unsignedBigInteger('ID')->primary();
            $table->text('text_message')->default('')->nullable();
            $table->binary('media_files')->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('guide');
    }
};
