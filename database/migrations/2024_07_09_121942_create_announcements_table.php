<?php

// database/migrations/xxxx_xx_xx_create_announcements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('extracted_text')->nullable();
            $table->text('aiquery')->nullable();
            $table->text('instructions')->nullable();

            $table->string('subject')->nullable();

            $table->integer('order')->default(0);
            $table->string('photo_path')->nullable();




            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();


        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
