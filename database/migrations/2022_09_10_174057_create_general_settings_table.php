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
            $table->time('bookingday_closing_time')->nullable();
            $table->integer('per_day_max_bookings')->nullable();
            $table->double('notice_period_hrs')->nullable();
            $table->double('refund')->default(0);
            $table->tinyInteger('gps_availability_status')->default(2);
            $table->tinyInteger('booking_daily_closing_time')->default(2);
            $table->string('birthday_message')->nullable();
            $table->string('message')->nullable();
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
