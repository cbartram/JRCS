<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('email');
            $table->string('phone');
            $table->string('volunteer_type');
            $table->tinyInteger('bebco_volunteer');
            $table->tinyInteger('jaco_volunteer');
            $table->tinyInteger('jbc_volunteer');
            //this can be modified later to include background consent and auth level if neccesary
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
        Schema::dropIfExists('profiles');
    }
}
