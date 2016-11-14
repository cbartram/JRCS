<?php

use App\Cico;
use App\Helpers\Helpers;


class HelperTest extends TestCase
{



    public function test() {
        $timestamp = Cico::where('check_in_timestamp', '2016-10-17 1:59 pm')->get();
        $this->assertEquals(true, Helpers::getElapsedTime($timestamp->created_at, $timestamp->updated_at));
    }
}
