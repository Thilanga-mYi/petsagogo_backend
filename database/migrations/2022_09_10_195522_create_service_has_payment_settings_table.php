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
        Schema::create('service_has_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_id');
            $table->double('30_min')->default(0);
            $table->double('1_hour')->default(0);
            $table->double('additional_hour_1')->default(0);
            $table->double('additional_visit_1')->default(0);
            $table->double('additional_pets_1')->default(0);
            $table->double('price_per_service')->default(0);
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
        Schema::dropIfExists('service_has_payment_settings');
    }
};
