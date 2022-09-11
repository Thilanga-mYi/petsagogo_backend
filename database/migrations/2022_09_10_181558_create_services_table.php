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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->tinyInteger('weekend_availibility');
            $table->tinyInteger('date_time_availibility');
            $table->tinyInteger('selected_time_shift')->nullable();
            $table->string('add_time_restriction_note')->nullable();
            $table->tinyInteger('no_of_visit_availability');
            $table->integer('no_of_visit_count')->default(0);
            $table->string('message')->nullable();
            $table->tinyInteger('status')->default(2);
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
        Schema::dropIfExists('services');
    }
};
