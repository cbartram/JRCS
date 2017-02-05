<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $table = 'emergency_contact';
    public    $primaryKey = 'volunteer_id';
    public    $incrementing = false;

}
