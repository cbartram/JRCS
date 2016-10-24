<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Metrics\Mood\Instability;
use Hal\Component\Result\ResultCollection;


/**
 * Estimates Instability of package
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class Instability {

    /**
     * Calculate instability
     *
     * @param ResultCollection $results Array of ResultSet
     * @return Result
     */
    public function calculate(ResultCollection $results) {

        $ca = $ce = $i = 0;

        foreach($results as $result) {
            $r = $result->getCoupling();
            if(is_object($r)) {
                $ce += $r->getEfferentCoupling();
                $ca += $r->getAfferentCoupling();
            }
        }

        $result = new Result;
        if($ca + $ce > 0) {
            $i = round($ce / ($ca + $ce), 2);
        }
        $result->setInstability($i);
        return $result;
    }

};
