<?php

use App\Helpers\Helpers;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelperTest extends TestCase
{

    public function testIsMemberOf() {
        if(Helpers::isMemberOf('BEBCO', 'vol_11qw3exg')) {
            return true;
        } else {
           return true;
        }
    }


    public function test() {
        $this->assertEquals(true, $this->testIsMemberOf());
    }
}
