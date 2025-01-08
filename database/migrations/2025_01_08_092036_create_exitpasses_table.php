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
        Schema::create('exitpasses', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');

            $table->text('qr');
            $table->string('destination');
            $table->string('responsible_person');
            $table->string('relationship_to_student');

            $table->date('exit_date');
            $table->time('exit_time');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exitpasses');
    }
};
