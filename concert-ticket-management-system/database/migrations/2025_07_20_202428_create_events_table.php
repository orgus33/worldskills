<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("venu_name");
            $table->string("venu_address");
            $table->string("city");
            $table->dateTime("event_date");
            $table->dateTime("doors_open");
            $table->dateTime("sale_starts_at");
            $table->dateTime("sale_ends_at");
            $table->integer("min_age");
            $table->integer("max_capacity");
            $table->integer("tickets_sold");
            $table->enum('status', ['active', 'cancelled', 'postponed', 'sold_out']);
            $table->string('image_url');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
