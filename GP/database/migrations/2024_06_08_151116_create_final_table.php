<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalsTable extends Migration
{
    public function up()
    {
        Schema::create('finals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->date('submission_date');
            $table->string('status')->default('pending');
            $table->string('pdf_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('finals');
    }
}
