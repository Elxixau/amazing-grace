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
          Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('subtitle')->nullable(); // jumbotron subtitle
            $table->text('excerpt')->nullable();  // ringkasan
            $table->longText('content')->nullable(); // deskripsi lengkap
            $table->string('price')->nullable();
            $table->string('banner_image')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('location_name')->nullable();
            $table->text('location_details')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->string('weekday_service_hours')->nullable();
            $table->string('weekend_service_hours')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('admin_phone')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('admin_whatsapp')->nullable();
            $table->string('admin_photo')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('show')->default(false);
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('posts');
    }
};
