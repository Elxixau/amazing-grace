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
    public function up()
    {
        Schema::create('ticket_groups', function (Blueprint $table) {
                $table->id();
                $table->uuid('group_code')->unique();       // untuk di-relasikan dengan tickets
                $table->string('group_name');
                $table->string('name')->nullable();
                $table->unsignedInteger('quota');

                $table->foreignId('ticket_setting_id')
                    ->nullable()
                    ->constrained('ticket_settings')
                    ->onDelete('cascade');

                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_groups');
    }
};
