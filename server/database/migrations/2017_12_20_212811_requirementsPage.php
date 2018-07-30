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
            $table->integer('absence')->nullable();
            $table->string('unexcused')->nullable(;
            $table->integer('fundraising')->nullable(;
            $table->integer('service')->nullable(;
            $table->integer('prof_dev')->nullable(;
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
