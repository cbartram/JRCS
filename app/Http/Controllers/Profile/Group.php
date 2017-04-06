<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 4/5/17
 * Time: 9:20 PM
 */

namespace App\Http\Controllers\Profile;


class Group
{
    private $name;
    private $color;
    private $auth;

    function __construct($name, $color, $auth)
    {
        $this->name = $name;
        $this->color = $color;
        $this->auth = $auth;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getAuth()
    {
        return $this->auth;
    }
}