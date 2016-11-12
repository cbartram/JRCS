<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $table
 * @property  $primaryKey
 * @property  $incrementing
 */
class Cico extends Model
{
    protected $table = 'volunteer_cico';
    public    $primaryKey = 'id';
    public    $incrementing = false;
}
