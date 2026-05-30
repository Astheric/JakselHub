<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('smart_city_metrics', function (Blueprint $table) {
            $table->id();
            $table->integer('aqi')->default(50);
            $table->integer('green_spaces_count')->default(150);
            $table->integer('public_transport_count')->default(25);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smart_city_metrics');
    }
};
