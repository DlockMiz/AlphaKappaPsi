<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequirementsPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('absence');
            $table->string('unexcused');
            $table->integer('spring_basketball');
            $table->integer('fall_basketball');
            $table->integer('fall_football');
            $table->integer('service');
            $table->integer('prof_dev');
            $table->string('dues');
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
