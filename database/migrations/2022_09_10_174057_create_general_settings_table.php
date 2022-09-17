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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('same_day_booking')->default(2);
            $table->tinyInteger('weekend_bookings')->default(2);
            $table->string('booking_daily_closing_time')->nullable();
            $table->integer('max_number_of_booking_per_day')->nullable();
            $table->double('notice_period_hrs')->nullable();
            $table->double('refund')->default(0);
            $table->tinyInteger('gps_status')->default(2);
            $table->string('birthday_message')->nullable();
            $table->string('booking_message')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('general_settings');
    }
};
