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
    Schema::create('user_reports', function (Blueprint $table) {
        $table->id('reportID');
        $table->unsignedBigInteger('userID');
        $table->text('description');
        $table->string('status')->default('Pending');
        $table->timestamps();

        $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
