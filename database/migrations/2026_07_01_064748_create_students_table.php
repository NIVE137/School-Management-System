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
    Schema::create('students', function (Blueprint $table) {
        $table->id();

        $table->string('image')->nullable();

        $table->string('student_name');

        $table->string('student_id')->unique();

        $table->string('mobile');

        $table->string('email')->unique();

        $table->string('password');

        $table->string('class_name');

        $table->text('address');

        $table->date('dob');

        $table->string('parent_name');

        $table->string('parent_mobile');

        $table->string('status')->default('active');
        
        $table->string('document')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
