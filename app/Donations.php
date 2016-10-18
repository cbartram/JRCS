<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'volunteer_id';
    public    $incrementing = false;
}
