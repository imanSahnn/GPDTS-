<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rate')->unsigned()->comment('Rating from 1 to 5');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
