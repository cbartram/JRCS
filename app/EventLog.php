<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $table = 'event_log';
    protected $primaryKey = 'event_id';
    public $incrementing = false;
}
