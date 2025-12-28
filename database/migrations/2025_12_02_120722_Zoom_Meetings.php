<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('zoom_meeting_id')->unique();
            $table->string('topic');
            $table->text('agenda')->nullable();
            $table->datetime('start_time');
            $table->integer('duration');
            $table->string('timezone')->default('UTC');
            $table->string('password')->nullable();
            $table->string('join_url');
            $table->string('start_url')->nullable();
            $table->json('zoom_response')->nullable();
            $table->enum('status', ['scheduled', 'started', 'ended', 'cancelled'])->default('scheduled');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('zoom_meetings');
    }
};
