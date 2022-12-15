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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedTinyInteger('rating');
            $table->text('content');

            $table->unsignedBigInteger('bookable_id')->index();
//            $table->foreign('bookable_id')->references('id')->on('bookables')s

            $table->unsignedBigInteger('booking_id')->index()->nullable();
//            $table->foreign('booking_id')->references('id')->on('bookables')->cascadeOnDelete();  // on bookings ??


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
        Schema::dropIfExists('reviews');
    }
};
