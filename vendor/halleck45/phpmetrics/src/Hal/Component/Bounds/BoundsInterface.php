<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\Bounds;
use Hal\Component\Result\ResultCollection;

/**
 * Bounds calculator
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
interface BoundsInterface {

    /**
     * Calculate
     *
     * @param ResultCollection $collection
     * @return \Hal\Component\Bounds\Result\ResultInterface
     */
    public function calculate(ResultCollection $collection);
}