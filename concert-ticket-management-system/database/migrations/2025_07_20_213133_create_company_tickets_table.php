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
        Schema::create('company_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Event::class);
            $table->foreignId("category_id")->constrained("ticket_categories");
            $table->enum('purchasable_type', ['User', 'Company']);
            $table->unsignedBigInteger('purchasable_id');
            $table->string('ticket_code');
            $table->float('price_paid');
            $table->enum('status', ['active', 'used', 'cancelled']);
            $table->timestamp('purchased_at');
            $table->foreignId("assigned_to")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_tickets');
    }
};
