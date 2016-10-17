<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
 protected $table = 'profiles';
 protected $primaryKey = 'id';
 public $incrementing = false;
}
