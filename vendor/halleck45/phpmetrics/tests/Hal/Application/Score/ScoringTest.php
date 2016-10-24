<?php
namespace Test\Hal\Application\Score;
use Hal\Application\Score\Scoring;


/**
 * @group score
 */
class ScoringTest extends \PHPUnit_Framework_TestCase {


    public function testCalculateScore() {
        $groupedResults = $this->getMockBuilder('\Hal\Component\Result\ResultCollection')->disableOriginalConstructor()->getMock();
        $collection = $this->getMockBuilder('\Hal\Component\Result\ResultCollection')->disableOriginalConstructor()->getMock();

        $bound = $this->getMockBuilder('\Hal\Component\Bounds\Result\ResultInterface')->disableOriginalConstructor()->getMock();
        $map = array(
            array('maintainabilityIndex', 65),
            array('effort', 12)
        );
        $bound->method('getAverage') ->will($this->returnValueMap($map));

        $boundFactory = $this->getMockBuilder('\Hal\Component\Bounds\BoundsInterface')->disableOriginalConstructor()->getMock();
        $boundFactory->expects($this->any())->method('calculate')->will($this->returnValue($bound));

        $scoring = new Scoring($boundFactory);
        $score = $scoring->calculate($collection, $groupedResults);

        $this->assertInstanceOf('Hal\Application\Score\Result', $score);
        $this->assertEquals(10.42, $score->get('Maintainability'), '', 0.2);
    }
}