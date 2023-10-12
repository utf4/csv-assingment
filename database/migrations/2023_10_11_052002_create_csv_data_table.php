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
        Schema::create('csv_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('unique_key')->unique();
            $table->string('product_title', 255);
            $table->text('product_description');
            $table->string('style_no', 100);
            $table->string('sanmar_mainframe_color', 100);
            $table->string('size', 100);
            $table->string('color_name', 100);
            $table->decimal('piece_price', 8, 2);
            $table->unsignedBigInteger('csv_id');
            $table->timestamps();

            // Define foreign key
            $table->foreign('csv_id')->references('id')->on('csvs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csv_data');
    }
};
