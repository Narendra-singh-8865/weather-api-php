<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
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
            $table->float('ttl_time')->nullable();
            $table->uuid('entity_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loggings');
    }
};
