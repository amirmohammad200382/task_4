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
        Schema::create('users', function (Blueprint $table) {
            //            $table->id();
//            $table->string('name');
//            $table->string('email')->unique();
//            $table->timestamp('email_verified_at')->nullable();
//            $table->string('password');
//            $table->rememberToken();
//
//            $table->timestamps();
//        });
            $table->id();
            $table->string('user_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->enum('gender', ['male', 'female']);
            $table->string('email');
            $table->string('phone_number');
            $table->string('password');
            $table->text('image');
            $table->string('address');
            $table->string('postalcode');
            $table->string('country');
            $table->string('province');
            $table->string('city');
            $table->enum('status', ['enable', 'disable']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
