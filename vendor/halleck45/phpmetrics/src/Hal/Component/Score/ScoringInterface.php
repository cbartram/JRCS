<?php

/*
* (c) Jean-François Lépine <https://twitter.com/Halleck45>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Hal\Component\Score;

use Hal\Component\Result\ResultCollection;

/**
 * Calculate score
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
interface ScoringInterface  {

    /**
     * Calculates score
     *
     * @param ResultCollection $collection
     * @param ResultCollection $groupedResults
     * @return mixed
     */
    public function calculate(ResultCollection $collection, ResultCollection $groupedResults);
}