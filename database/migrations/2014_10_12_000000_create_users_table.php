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
            $table->unsignedInteger('usertype')->nullable();
            $table->string('name', 100);
            $table->string('username', 45)->nullable();
            $table->string('image', 100)->nullable();
            $table->date('dob')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('tel', 12)->nullable();
            $table->string('mobile', 12);
            $table->enum('mobile_verified', [1, 2])->default(2);
            $table->string('email', 45)->unique();
            $table->enum('email_verified', [1, 2])->default(2);

            $table->string('staff_id_proff')->nullable();
            $table->string('staff_address_proff')->nullable();

            $table->string('company_name', 100)->nullable();
            $table->string('company_address', 100)->nullable();
            $table->string('company_tel', 12)->nullable();
            $table->string('company_mobile', 12)->nullable();
            $table->string('company_email_address', 45)->nullable();
            $table->string('company_website', 45)->nullable();
            $table->date('company_business_start_date')->nullable();

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
