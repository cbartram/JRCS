<?php
namespace Test\Hal\Metrics\Complexity\Text\Halstead;

use Hal\Metrics\Complexity\Text\Halstead\Halstead;
use Hal\Metrics\Complexity\Text\Halstead\Result;
use Hal\Component\Token\Tokenizer;
use Hal\Component\Token\TokenType;

/**
 * @group halstead
 * @group metric
 */
class HalsteadTest extends \PHPUnit_Framework_TestCase {

    public function testHalsteadServiceReturnsResult() {

        $tokenType = $this->getMock('\Hal\Component\Token\TokenType');
        $tokenType->expects($this->any())
            ->method('isOperand')
            ->will($this->returnValue(true));
        $filename = tempnam(sys_get_temp_dir(), 'tmp-unit');
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $object = new Halstead($tokenType);
        $this->assertInstanceOf("\Hal\Metrics\Complexity\Text\Halstead\Result", $object->calculate($tokens));
        unlink($filename);
    }

    public function testHalsteadResultCanBeConvertedToArray() {

        $result = new Result();
        $array = $result->asArray();

        $this->assertArrayHasKey('volume', $array);
        $this->assertArrayHasKey('length', $array);
        $this->assertArrayHasKey('vocabulary', $array);
        $this->assertArrayHasKey('effort', $array);
        $this->assertArrayHasKey('difficulty', $array);
        $this->assertArrayHasKey('time', $array);
        $this->assertArrayHasKey('bugs', $array);
    }


    /**
     * @dataProvider provideFilesAndCounts
     */
    public function testHalsteadGiveValidValues($filename, $N1, $N2, $n1, $n2, $N, $V, $L, $D, $E, $T, $I) {
        $tokenType = new TokenType(); // please don't mock this: it make no sense else
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $halstead = new Halstead($tokenType);
        $r = $halstead->calculate($tokens);

        $this->assertEquals($N1, $r->getNumberOfOperators());
        $this->assertEquals($n1, $r->getNumberOfUniqueOperators());
        $this->assertEquals($N2, $r->getNumberOfOperands());
        $this->assertEquals($n2, $r->getNumberOfUniqueOperands());

        $this->assertEquals($N, $r->getLength(), 'length');
        $this->assertEquals($V, $r->getVolume(), 'volume');
        $this->assertEquals($L, $r->getLevel(), 'level');
        $this->assertEquals($D, $r->getDifficulty(), 'difficulty');
        $this->assertEquals($E, $r->getEffort(), 'effort');
        $this->assertEquals($E, $r->getEffort(), 'effort');
        $this->assertEquals($T, $r->getTime(), 'time');
        $this->assertEquals($I, $r->getIntelligentContent(), 'intelligent content');

    }

    public function provideFilesAndCounts() {
        return array(
            //                                                          N       V           L       D       E           T       I
            array(__DIR__.'/../../../../../resources/halstead/f1.php', 3 , 4, 3, 3        , 7     , 18.09     , 0.5   , 2     , 36.19     , 2    , 9.05 ) // twice
            , array(__DIR__.'/../../../../../resources/halstead/f2.php', 6, 7, 4, 3       , 13    , 36.5      , 0.21  , 4.67  , 170.31    , 9    , 7.82) // max
            , array(__DIR__.'/../../../../../resources/halstead/f4.php', 14, 14, 9, 6     , 28    , 109.39    , 0.1   , 10.5  , 1148.63   , 64   , 10.42) // f_while
            , array(__DIR__.'/../../../../../resources/halstead/f3.php', 19, 10, 8, 6     , 29    , 110.41    , 0.15  , 6.67  , 736.09    , 41   , 16.56) // f_switch
        );
    }
}
