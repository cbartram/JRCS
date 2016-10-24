<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\Result;
use Hal\Component\Score\ScoreInterface;


/**
 * ResultSet
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class ResultCollection implements ExportableInterface, \IteratorAggregate, \ArrayAccess, \Countable {

    /**
     * Results
     *
     * @var array
     */
    private $results = array();

    /**
     * @var ScoreInterface
     */
    private $score;

    /**
     * Push resultset
     *
     * @param ResultSetInterface $resultset
     * @return $this
     */
    public function push(ResultSetInterface $resultset) {
        $this->results[$resultset->getName()] = $resultset;
        return $this;
    }

    /**
     * @inheritedDoc
     */
    public function asArray() {
        $array = array();
        foreach($this->results as $result) {
            array_push($array, $result->asArray());
        }
        return $array;
    }

    /**
     * @inheritedDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->results);
    }

    /**
     * @inheritedDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->results[$offset]);
    }

    /**
     * @inheritedDoc
     */
    public function offsetGet($offset)
    {
        return $this->results[$offset];
    }

    /**
     * @inheritedDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->results[$offset] = $value;
    }

    /**
     * @inheritedDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->results[$offset]);
    }

    /**
     * @inheritedDoc
     */
    public function count()
    {
        return sizeof($this->results, COUNT_NORMAL);
    }

    /**
     * Get by file
     *
     * @param $key
     * @return null|ResultSet
     */
    public function get($key) {
        return isset($this->results[$key]) ? $this->results[$key] : null;
    }

    /**
     * @return ScoreInterface
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param ScoreInterface $score
     * @return $this
     */
    public function setScore(ScoreInterface $score)
    {
        $this->score = $score;
        return $this;
    }
}