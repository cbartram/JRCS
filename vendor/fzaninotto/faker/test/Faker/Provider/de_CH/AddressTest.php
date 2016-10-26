<?php

namespace Faker\Test\Provider\de_CH;

use Faker\Generator;
use Faker\Provider\de_CH\Address;
use Faker\Provider\de_CH\Person;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }

    /**
     * @tests
     */
    public function canton ()
    {
        $canton = $this->faker->canton();
        $this->assertInternalType('array', $canton);
        $this->assertCount(1, $canton);

        foreach ($canton as $cantonShort => $cantonName){
            $this->assertInternalType('string', $cantonShort);
            $this->assertEquals(2, strlen($cantonShort));
            $this->assertInternalType('string', $cantonName);
            $this->assertGreaterThan(2, strlen($cantonName));
        }
    }

    /**
     * @tests
     */
    public function cantonName ()
    {
        $cantonName = $this->faker->cantonName();
        $this->assertInternalType('string', $cantonName);
        $this->assertGreaterThan(2, strlen($cantonName));
    }

    /**
     * @tests
     */
    public function cantonShort ()
    {
        $cantonShort = $this->faker->cantonShort();
        $this->assertInternalType('string', $cantonShort);
        $this->assertEquals(2, strlen($cantonShort));
    }

    /**
     * @tests
     */
    public function address (){
        $address = $this->faker->address();
        $this->assertInternalType('string', $address);
    }
}
