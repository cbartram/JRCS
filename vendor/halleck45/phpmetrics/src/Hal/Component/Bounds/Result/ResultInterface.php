<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\Bounds\Result;


/**
 * ResultBoundary
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
interface ResultInterface {

    /**
     * Get average for
     *
     * @param string $key
     * @return null|float
     */
    public function getAverage($key);

    /**
     * Get min for
     *
     * @param $key
     * @return null|float
     */
    public function getMin($key);

    /**
     * Get max for
     *
     * @param $key
     * @return null|float
     */
    public function getMax($key);

    /**
     * Get sum for
     *
     * @param string $key
     * @return null|float
     */
    public function getSum($key);

    /**
     * Get any
     *
     * @param string $type
     * @param string $key
     * @return null|float
     */
    public function get($type, $key);

    /**
     * Has key ?
     *
     * @param $key
     * @return boolean
     */
    public function has($key);
}