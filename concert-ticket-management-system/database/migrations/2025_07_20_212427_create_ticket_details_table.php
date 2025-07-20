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
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Event::class);
            $table->foreignId("category_id")->constrained("ticket_categories");
            $table->enum('purchasable_type', ['User', 'Company']);
            $table->integer('purchasable_id');
            $table->string('ticket_code');
            $table->float('price_paid');
            $table->enum('status', ['active', 'used', 'cancelled']);
            $table->timestamp('purchased_at');
            $table->string('qr_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_details');
    }
};
