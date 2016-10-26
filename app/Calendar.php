<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar_events';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
