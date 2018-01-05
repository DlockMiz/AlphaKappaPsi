<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('location');
            $table->string('date');
            $table->integer('month');
            $table->string('time');
            $table->json('attended_users');
            $table->json('non_attended_users');
            $table->integer('max_users');
            $table->string('hours');
            $table->json('signed_users');
            $table->string('event_type');
            $table->string('description');
            $table->integer('completed');
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
        //
    }
}
