<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('requests')) {
            Schema::create('requests', function (Blueprint $table) {
                $table->id('requestID'); // Primary Key
                $table->foreignId('userID')->constrained('Aminusers')->onDelete('cascade');
                $table->foreignId('providerID')->nullable()->constrained('service_providers', 'id')->onDelete('set null');
                $table->enum('status', ['pending', 'approved', 'rejected', 'in-progress', 'completed', 'canceled'])->default('pending');
                $table->string('requestType', 100);
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
                $table->text('description')->nullable();
                $table->timestamps(0);
            });
        }
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
