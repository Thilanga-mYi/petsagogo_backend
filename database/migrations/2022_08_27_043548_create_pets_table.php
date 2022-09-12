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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('owner_id');
            $table->String('name', 45);
            $table->String('image', 100)->nullable();
            $table->date('dob');
            $table->enum('gender', [1, 2])->default(1);
            $table->String('species', 100)->nullable();
            $table->String('breed', 45)->nullable();
            $table->enum('male_neuterated', [1, 2])->default(2);
            $table->String('injuries', 100)->nullable();
            $table->String('note', 255)->nullable();
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
        Schema::dropIfExists('pets');
    }
};
