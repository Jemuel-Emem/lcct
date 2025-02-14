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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->string('name');
            $table->string('sex');
            $table->string('date_of_birth');
            $table->string('address');
            $table->string('grade');
            $table->string('age');
            $table->string('height');
            $table->string('weight');
            $table->string('vision');
            $table->string('bp');
            $table->string('nameoffather');
            $table->string('fatheroccupation');
            $table->string('nameofmother');
            $table->string('motheroccupation');
            $table->string('document_path')->nullable();
            $table->string('year_uploaded')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
