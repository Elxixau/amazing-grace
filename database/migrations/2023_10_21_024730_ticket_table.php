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
     public function up(): void
    {
        
    // 1️⃣ Buat tabel tickets dulu TANPA foreign key
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('ticket_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->unsignedTinyInteger('seat_count');
            $table->uuid('seat_group'); // disesuaikan menjadi uuid

            $table->timestamps();

            // Relasi ke ticket_groups.group_code
            $table->foreign('seat_group')
                ->references('group_code')
                ->on('ticket_groups')
                ->onDelete('cascade');
        });

    

    }

    public function down(): void
    {
      
        Schema::dropIfExists('tickets');
    }
};
