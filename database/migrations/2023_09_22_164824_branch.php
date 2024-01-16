<?php

use App\Models\Branch;
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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses');
        });


        Schema::table('b24_deals', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->default(1); // Define the branch_id column
            $table->foreign('branch_id')->references('id')->on('branches');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
