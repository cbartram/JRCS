<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffProfile extends Authenticatable
{
    protected $table = 'staff_profile2';
    public    $primaryKey = 'id';
    public    $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

}
