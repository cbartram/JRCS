<?php
namespace Test\Hal\Component\OOP;

use Hal\Component\OOP\Extractor\CallExtractor;
use Hal\Component\Token\TokenCollection;
use Hal\Metrics\Design\Component\MaintainabilityIndex\MaintainabilityIndex;
use Hal\Metrics\Design\Component\MaintainabilityIndex\Result;
use Hal\Component\OOP\Extractor\Extractor;
use Hal\Component\OOP\Extractor\MethodExtractor;
use Hal\Component\OOP\Extractor\Searcher;

/**
 * @group oop
 * @group extractor
 */
class CallExtractorTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider provideCalls
     */
    public function testExternalCallsAreFound($expected, $n, $code) {
        $searcher = new Searcher();
        $callExtractor = new CallExtractor($searcher);
        $tokens = new TokenCollection(token_get_all($code));
        $name = $callExtractor->extract($n, $tokens);
        $this->assertEquals($expected, $name);
    }

    public function provideCalls() {
        return array(
            array('Foo', 2, '<?php Foo::bar(); ')
            , array('Foo', 1, '<?php new Foo; ')
            , array('CurrentClass', 12, '<?php class CurrentClass extends ExtendClass { self::bar(); }')
            , array('ExtendClass', 12, '<?php class CurrentClass extends ExtendClass { parent::bar(); }')
            , array('\ExtendClass', 13, '<?php class CurrentClass extends \ExtendClass { parent::bar(); }')
            , array('CurrentClass', 13, '<?php class CurrentClass extends \ExtendClass { static::bar(); }')
            , array('\ExtendClass', 13, '<?php class CurrentClass extends \ExtendClass { parent::__clone(); }')
            , array('CurrentClass', 13, '<?php class CurrentClass extends \ExtendClass { self::__clone(); }')
            , array('CurrentClass', 13, '<?php class CurrentClass extends \ExtendClass { static::__clone(); }')
        );
    }

    public function testClassMemberDirectAccessOnInstanciationIsParsed() {
        $code = '<?php
class A {
    function foo() {
        (new B)->doAny();
    }
}';
        $searcher = new Searcher();
        $callExtractor = new CallExtractor($searcher);
        $tokens = new TokenCollection(token_get_all($code));
        $n = 16;
        $name = $callExtractor->extract($n, $tokens);
        $this->assertEquals('B', $name);
    }
}

