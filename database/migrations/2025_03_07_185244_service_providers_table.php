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
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id('providerID'); // Primary Key, auto-incrementing ID
            $table->string('name'); // Service provider's name
            $table->string('service_type'); // Type of service provided (e.g., cleaning, maintenance)
            $table->string('contact_info')->nullable(); // Contact information for the provider (optional)
            $table->timestamps(); // Automatically adds 'created_at' and 'updated_at'
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
