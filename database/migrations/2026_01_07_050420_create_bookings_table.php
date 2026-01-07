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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        // Relasi neng User (sopo sing pesen) lan Package (paket opo sing dipilih)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('package_id')->constrained()->onDelete('cascade');
        
        $table->date('booking_date');       // Tanggal pemotretan
        $table->text('location');           // Lokasi pemotretan
        $table->text('notes')->nullable();  // Catatan tambahan (misal: tema baju)
        $table->decimal('total_price', 15, 2); // Rega pas pesen (jago-jago nek rega paket malih)
        
        // Status pesenan: PENDING, CONFIRMED, COMPLETED, CANCELLED
        $table->string('status')->default('PENDING');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
