<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolunteerInformation extends Model
{
    protected $table = 'volunteer_information';
    public    $primaryKey = 'volunteer_id';
    public    $incrementing = false;

}
