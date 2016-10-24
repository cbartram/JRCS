<?php
namespace Test\Hal\Component\OOP;

use Hal\Component\OOP\Reflected\ReflectedInterface;
use Hal\Metrics\Design\Component\MaintainabilityIndex\MaintainabilityIndex;
use Hal\Metrics\Design\Component\MaintainabilityIndex\Result;
use Hal\Component\OOP\Extractor\Extractor;

/**
 * @group oop
 */
class AbstractnessExtractorTest extends \PHPUnit_Framework_TestCase {


    /**
     * @dataProvider provideInterfaces
     */
    public function testInterfacesAreFound($filename, $interfaces) {

        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $found = 0;
        foreach($result->getClasses() as $class) {
            if($class instanceof ReflectedInterface) {
                $found++;
                $this->assertContains($class->getFullname(), $interfaces);
            }
        }
        $this->assertEquals(sizeof($interfaces, COUNT_NORMAL), $found);
    }

    public function provideInterfaces() {
        return array(
            array(__DIR__.'/../../../resources/oop/abstract1.php', array())
            , array(__DIR__.'/../../../resources/oop/abstract2.php', array('\Titi'))
            , array(__DIR__.'/../../../resources/oop/abstract3.php', array())
            , array(__DIR__.'/../../../resources/oop/abstract4.php', array('\Foo\Bar'))
        );
    }



    /**
     * @dataProvider provideAbstractClasses
     */
    public function testAbstractClassesAreFound($filename, $expected) {

        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $found = 0;
        foreach($result->getClasses() as $class) {
            if($class->isAbstract()) {
                $found++;
                $this->assertContains($class->getFullname(), $expected);
            }
        }
        $this->assertEquals(sizeof($expected, COUNT_NORMAL), $found);
    }

    public function provideAbstractClasses() {
        return array(
            array(__DIR__.'/../../../resources/oop/abstract1.php', array())
            , array(__DIR__.'/../../../resources/oop/abstract2.php', array())
            , array(__DIR__.'/../../../resources/oop/abstract3.php', array('\Titi'))
        );
    }

}
