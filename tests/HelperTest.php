<?php

use App\Helpers\Helpers;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelperTest extends TestCase
{



    public function test() {
        $this->assertEquals(true, Helpers::fromUTC("6:45 pm", 'ABC'));
    }
}
