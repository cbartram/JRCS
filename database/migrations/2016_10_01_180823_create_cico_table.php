<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_cico', function (Blueprint $table) {
        $table->string('id');
        $table->primary('id');
        $table->string('email');
        $table->string('check_in_timestamp');
        $table->string('check_out_timestamp')->nullable();
        $table->string('volunteer_group');
        $table->string('volunteer_type');
        $table->string('volunteer_program')->nullable();
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
        Schema::dropIfExists('volunteer_cico');
    }
}
