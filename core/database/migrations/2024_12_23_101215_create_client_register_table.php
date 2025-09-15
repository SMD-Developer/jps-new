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
        Schema::create('client_register', function (Blueprint $table) {
            $table->id();
            
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('setPassword')->nullable();
            $table->string('userName')->nullable();
            $table->string('idCardNumber')->nullable();
            $table->string('registeredAddress')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('city')->nullable();
            $table->string('mobileNumber')->nullable();
            $table->string('landline')->nullable();
            $table->string('securityAnswers1')->nullable();
            $table->string('securityAnswers2')->nullable();
            
                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_register');
    }
};
