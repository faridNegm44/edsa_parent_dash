<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PollUsersToTeachersOnly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_users_to_teachers_only', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('teacher_id');
            $table->integer('group_id');
            $table->integer('question_id');
            $table->text('answer')->nullable();
            $table->string('total')->nullable();
            $table->string('special');
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
        Schema::dropIfExists('poll_users_to_teachers_only');
    }
}
