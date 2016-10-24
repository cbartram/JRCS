<?php
namespace Test\Hal\Component\OOP;

use Hal\Component\Token\TokenCollection;
use Hal\Metrics\Design\Component\MaintainabilityIndex\MaintainabilityIndex;
use Hal\Metrics\Design\Component\MaintainabilityIndex\Result;
use Hal\Component\OOP\Extractor\Extractor;
use Hal\Component\OOP\Extractor\MethodExtractor;
use Hal\Component\OOP\Extractor\Searcher;

/**
 * @group oop
 * @group extractor
 * @group php7
 */
class Php7AnonymousClassExtractorTest extends \PHPUnit_Framework_TestCase {

    public function testAnonymousClassIsFound() {

        $filename = __DIR__.'/../../../resources/oop/php7-1.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(2, sizeof($classes));

        $mother = $classes[0];
        $anonymous = $classes[1];
        $this->assertEquals('\\My\\Mother', $mother->getFullname(), 'mother class is found');
        $this->assertEquals('class@anonymous', $anonymous->getName(), 'anonymous class is found');
        $this->assertEquals('\\My\\Mother', $anonymous->getParent(), 'mother of anonymous class is found');
        $this->assertEquals('\\', $anonymous->getNamespace(), 'anonymous class is in default namespace');
    }

    public function testInterfacesOfAnonymousClassAreFound() {

        $filename = __DIR__.'/../../../resources/oop/php7-2.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(4, sizeof($classes));

        $mother = $classes[0];
        $interface1 = $classes[1];
        $interface2 = $classes[2];
        $anonymous = $classes[3];
        $this->assertEquals('\\My\\Mother', $mother->getFullname(), 'mother class is found');
        $this->assertEquals('\\My\\Contract1', $interface1->getFullname(), 'interface is found');
        $this->assertEquals('\\My\\Contract2', $interface2->getFullname(), 'interface is found');
        $this->assertEquals('class@anonymous', $anonymous->getName(), 'anonymous class is found');
        $this->assertEquals('\\My\\Mother', $anonymous->getParent(), 'mother of anonymous class is found');
        $this->assertEquals(array('\\My\\Contract1', '\\My\\Contract2'), $anonymous->getInterfaces(), 'interfaces of anonymous class are found');
    }

    public function testAnonymousClassDoesNotBreakMainClassExtractor() {
        $filename = __DIR__.'/../../../resources/oop/php7-3.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(2, sizeof($classes));
        $main = $classes[0];
        $anonymous = $classes[1];
        $this->assertEquals('\\My\\MainClass', $main->getFullname());
        $this->assertEquals('class@anonymous', $anonymous->getName());

        $methods = $main->getMethods();
        $this->assertEquals(array('foo', 'bar'), array_keys($main->getMethods()), 'Methods of class containing anonymous class are found');
        $this->assertEquals(array('sub'), array_keys($anonymous->getMethods()), 'Methods of anonymous class contained in class are found');
    }

    public function testInnerClassAreAttachedToMainClassExtractor() {
        $filename = __DIR__.'/../../../resources/oop/php7-4.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(4, sizeof($classes));
        $main = $classes[0];
        $this->assertEquals('\\My\\MainClass', $main->getFullname());

        $anonymousClasses = $main->getAnonymousClasses();
        $this->assertEquals(3, sizeof($anonymousClasses));
    }

    public function testMethodsOfAnonymousClassesAreFound() {
        $filename = __DIR__.'/../../../resources/oop/php7-7.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(2, sizeof($classes));
        $main = $classes[0];
        $anonymous = $classes[1];

        $this->assertEquals(3, sizeof($anonymous->getMethods()));
    }

    public function testDependenciesOfMethodsIncludeDependenciesOfAnonymousClasses()
    {
        $filename = __DIR__ . '/../../../resources/oop/php7-5.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(7, sizeof($classes));
        $class1 = $classes[2];
        $class2 = $classes[4];
        $this->assertEquals('\\My\\B', $class1->getFullname());
        $this->assertEquals('\\My\\C', $class2->getFullname());


        $this->assertEquals(array('\\My\\D', '\\My\\A', '\\My\\Mother'), $class1->getDependencies());
    }


    public function testMultipleClassesWithSameMethodName()
    {
        $filename = __DIR__ . '/../../../resources/oop/php7-6.php';
        $tokens = (new \Hal\Component\Token\Tokenizer())->tokenize($filename);
        $extractor = new Extractor();
        $result = $extractor->extract($tokens);

        $classes = $result->getClasses();
        $this->assertEquals(7, sizeof($classes));
        $mother = $classes[0];
        $class1 = $classes[2];
        $class2 = $classes[4];
        $this->assertEquals('\\My\\B', $class1->getFullname());
        $this->assertEquals('\\My\\C', $class2->getFullname());


        $this->assertEquals(array('\\My\\D', '\\My\\A', '\\My\\Mother'), $class1->getDependencies());
    }


}
