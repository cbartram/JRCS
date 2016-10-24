<?php
namespace Test\Hal\Component\OOP;

use Hal\Component\OOP\Reflected\ReflectedMethod;
use Hal\Component\OOP\Reflected\ReflectedReturn;
use Hal\Component\OOP\Resolver\TypeResolver;
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
class MethodExtractorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providesForMethodsArgs
     */
    public function testMethodsAreFound($filename, $expectedMethods) {

        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        foreach($result->getClasses() as $index => $class) {

            $this->assertCount(sizeof($expectedMethods), $class->getMethods());

            foreach($class->getMethods() as $method) {
                $found = false;
                foreach($expectedMethods as $expectedMethod) {

                    list($methodName, $args) = $expectedMethod;

                    if($methodName == $method->getName()) {
                        $found = true;

                        $this->assertCount(sizeof($args), $method->getArguments(), sprintf('all arguments of "%s()" found', $method->getName()));

                        foreach($method->getArguments() as $pos => $argument) {
                            list($varname, $type, $required) = $args[$pos];

                            $this->assertEquals($varname, $argument->getName(), 'argument name found');
                            $this->assertEquals($type, $argument->getType(), 'argument type found');
                            $this->assertEquals($required, $argument->isRequired(), 'argument is required found');
                        }

                    }
                }

                if(!$found) {
                    throw new \Exception(sprintf('method "%s" is found but wan not expected', $method->getName()));
                }

            }

        }

    }


    public function testContentOfMethodIsFound() {
        $filename = __DIR__.'/../../../resources/oop/f6.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor(new \Hal\Component\Token\Tokenizer());
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $class = $classes[0];
        $methods = $class->getMethods();
        $method = $methods['foo'];
        $expected = <<<EOT
\$a = strtoupper((string)\$a); return \$a;
EOT;

        $this->assertEquals($expected, $method->getContent());

        $methods = $class->getMethods();
        $method = end($methods);
        $expected = <<<EOT
\$x = 1 * 2; die();
EOT;
        $this->assertEquals($expected, $method->getContent());
    }

    public function providesForMethodsArgs() {
        return array(
            array(__DIR__.'/../../../resources/oop/f1.php', array())
            , array(__DIR__.'/../../../resources/oop/f2.php', array(
                // method
                array('foo', array(
                    // args
                ))
                // method
                , array('bar', array(
                    // args
                    array('$c', 'AnotherClass', false)
                ))
                // method
                , array('baz', array(
                    // args
                    array('$c', '\Namespaced\AnotherClass', true)
                    , array('$c2', 'AnotherClass', false)
                ))
              )
            )

        );
    }


    /**
     * @dataProvider provideCodeForReturns
     */
    public function testReturnsAreFound($expected, $code) {
        $searcher = new Searcher();
        $methodExtractor = new MethodExtractor($searcher);

        $tokens = new TokenCollection(token_get_all($code));
        $n = 1;
        $method = $methodExtractor->extract($n, $tokens);
        $this->assertEquals(sizeof($expected), sizeof($method->getReturns()));
        $this->assertEquals($expected, $method->getReturns());
    }

    public function provideCodeForReturns() {
        return array(
            array(array(new ReflectedReturn(TypeResolver::TYPE_INTEGER, '1', ReflectedReturn::ESTIMATED_TYPE_HINT)), '<?php public function foo() { return 1; }')
            , array(array(), '<?php public function foo() { }')
            , array(
                array(
                    new ReflectedReturn(TypeResolver::TYPE_INTEGER, '1', ReflectedReturn::ESTIMATED_TYPE_HINT),
                    new ReflectedReturn(TypeResolver::TYPE_INTEGER, '2', ReflectedReturn::ESTIMATED_TYPE_HINT)
                ),
                '<?php public function foo() { if(true) { return 1; } return 2; }'
            )
            , array(array(), '<?php public function bar() { $x->a();  }')
        );
    }

    /**
     * @dataProvider provideCodeForNew
     */
    public function testInstanciationsAreFound($expected, $code) {
        $searcher = new Searcher();
        $methodExtractor = new MethodExtractor($searcher);

        $tokens = new TokenCollection(token_get_all($code));
        $n = 1;
        $method = $methodExtractor->extract($n, $tokens);

        $this->assertEquals($expected, $method->getDependencies());
    }

    public function provideCodeForNew() {
        return array(
            /*array(array(), '<?php public function foo() { return 1; }')
            , array(array('A'), '<?php public function bar() { new A();  }')
            , array(array('A'), '<?php public function bar() { new A(1,2,3);  }')
            , */array(array(), '<?php public function bar($d = false) {  }')
//            , array(array(), '<?php public function bar($d = false) {  }')
        );
    }

    public function testGetterAreFound() {
        $filename = __DIR__.'/../../../resources/oop/f8.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor(new \Hal\Component\Token\Tokenizer());
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $class = $classes[0];
        $methods = $class->getMethods();
        $this->assertTrue($methods['getA']->isGetter());
        $this->assertTrue($methods['isGood']->isGetter());
        $this->assertTrue($methods['isTypedGood']->isGetter());
        $this->assertTrue($methods['hasA']->isGetter());
        $this->assertFalse($methods['foo']->isGetter());
        $this->assertFalse($methods['setA']->isGetter());
    }

    public function testSetterAreFound() {
        $filename = __DIR__.'/../../../resources/oop/f8.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $class = $classes[0];
        $methods = $class->getMethods();
        $this->assertFalse($methods['getA']->isSetter());
        $this->assertFalse($methods['foo']->isSetter());
        $this->assertTrue($methods['setA']->isSetter());
        $this->assertTrue($methods['setB']->isSetter());
    }

    /**
     * @dataProvider provideCodeForVisibility
     */
    public function testVisibilityIsFound($filename, $expected) {
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $class = $classes[0];
        $methods = $class->getMethods();
        $method = $methods['foo'];
        $this->assertEquals($expected, $method->getVisibility());
    }

    public function provideCodeForVisibility() {
        return array(
            array(__DIR__.'/../../../resources/oop/visibility1.php', ReflectedMethod::VISIBILITY_PUBLIC,'undeclared visibility is public'),
            array(__DIR__.'/../../../resources/oop/visibility2.php', ReflectedMethod::VISIBILITY_PUBLIC, 'public is found'),
            array(__DIR__.'/../../../resources/oop/visibility3.php', ReflectedMethod::VISIBILITY_PRIVATE, 'private is found'),
            array(__DIR__.'/../../../resources/oop/visibility4.php', ReflectedMethod::VISIBILITY_PROTECTED, 'protected is found'),
        );
    }

    /**
     * @dataProvider provideCodeForState
     */
    public function testStateIsFound($filename, $expected) {
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $class = $classes[0];
        $methods = $class->getMethods();
        $method = $methods['foo'];
        $this->assertEquals($expected, $method->getState());
    }

    public function provideCodeForState() {
        return array(
            array(__DIR__.'/../../../resources/oop/state1.php', ReflectedMethod::STATE_LOCAL),
            array(__DIR__.'/../../../resources/oop/state2.php', ReflectedMethod::STATE_STATIC),
            array(__DIR__.'/../../../resources/oop/state3.php', ReflectedMethod::STATE_STATIC),
            array(__DIR__.'/../../../resources/oop/state4.php', ReflectedMethod::STATE_STATIC),
            array(__DIR__.'/../../../resources/oop/state5.php', ReflectedMethod::STATE_LOCAL),
        );
    }


    /**
     * @dataProvider provideCodeForCalls
     */
    public function testCallsAReFound($filename, $expectedExternalCalls, $expectedInternalCalls) {
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $this->assertEquals(1, sizeof($classes));
        $class = $classes[0];
        $methods = $class->getMethods();
        $method = $methods['foo'];
        $this->assertEquals($expectedExternalCalls, sizeof($method->getExternalCalls()));
        $this->assertEquals($expectedInternalCalls, sizeof($method->getInternalCalls()));

    }

    public function provideCodeForCalls() {
        return array(
            array(__DIR__.'/../../../resources/oop/call1.php', 2, 0),
            array(__DIR__.'/../../../resources/oop/call2.php', 0, 2),
        );
    }


    public function testMagicMethodsAreWellConsidered() {
        $filename = __DIR__.'/../../../resources/oop/magicmethods1.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $class = $classes[0];
        $methods = $class->getMethods();
        $this->assertEquals(3, sizeof($methods));

        $this->assertArrayHasKey('foo', $methods);
        $this->assertArrayHasKey('__clone', $methods);
        $this->assertArrayHasKey('__construct', $methods);
    }

    public function testInstanciationAndCallsOfMagicMethodsAreWellConsideredAsDependency() {
        $filename = __DIR__.'/../../../resources/oop/magicmethods2.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $this->assertEquals(2 , sizeof($classes));
        $class = $classes[1];
        $methods = $class->getMethods();
        $this->assertEquals(3, sizeof($methods));

        $method = $methods['__clone'];
        $this->assertEquals(array('\ModelOne'), $method->getDependencies());

        $method = $methods['__construct'];
        $this->assertEquals(array('\ModelOne', 'Context', 'UnionType'), $method->getDependencies());

    }

    public function testReturningNewStaticIsWellParsed() {
        $filename = __DIR__.'/../../../resources/oop/php7-static-as-dep1.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);
        $classes = $result->getClasses();
        $this->assertEquals(1 , sizeof($classes));
        $class = $classes[0];
        $this->assertEquals(array('\\My\\MyClass'), $class->getDependencies());

    }
}
