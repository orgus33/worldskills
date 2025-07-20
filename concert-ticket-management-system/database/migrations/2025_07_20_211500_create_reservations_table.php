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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Event::class);
            $table->foreignId("category")->constrained("ticket_categories")->cascadeOnDelete();
            $table->integer("quantity");
            $table->string("expires_at");
            $table->enum("status", ["active", "confirmed", "cancelled", "expired"]);
            $table->enum("purchaser_type", ["user", "company"]);
            $table->integer("purchaser_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
