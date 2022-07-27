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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('usertype')->default(2);
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('mobile');
            $table->string('email')->unique();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_tel')->nullable();
            $table->string('company_mobile')->nullable();
            $table->string('company_email_address')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_business_start_date')->nullable();
            $table->string('company_username')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
