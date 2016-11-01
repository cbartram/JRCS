<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 11/1/16
 * Time: 12:51 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    protected $table = 'programs';
    protected $primaryKey = 'id';
    public $incrementing = false;
}