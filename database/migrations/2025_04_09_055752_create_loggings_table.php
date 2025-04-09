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
        Schema::create('loggings', function (Blueprint $table) {
            $table->id();
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->json('headers')->nullable();
            $table->string('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->integer('response_code')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('ttl_time')->nullable();
            $table->uuid('entity_id')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loggings');
    }
};
