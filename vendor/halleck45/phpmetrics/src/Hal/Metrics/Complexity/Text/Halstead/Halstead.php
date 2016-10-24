<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Metrics\Complexity\Text\Halstead;
use Hal\Component\Token\TokenCollection;
use Hal\Component\Token\TokenType;


/**
 * Calculates Halstead complexity
 *
 *      According Wikipedia, "Halstead complexity measures are software metrics introduced by Maurice Howard Halstead in
 *      1977 as part of his treatise on establishing an empirical science of software development.
 *      Halstead makes the observation that metrics of the software should reflect the implementation or
 *      expression of algorithms in different languages, but be independent of their execution on a specific platform.
 *      These metrics are therefore computed statically from the code."
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class Halstead {

    /**
     * Operators
     *
     * @var array
     */
    private $operators = array();

    /**
     *
     * Operands
     *
     * @var array
     */
    private $operands = array();

    /**
     * Allows to determine what is the type of tokens
     *
     * @var TokenType
     */
    private $tokenType;

    /**
     * Constructor
     *
     * @param \Hal\Component\Token\TokenType $tokenType
     */
    public function __construct(\Hal\Component\Token\TokenType $tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * Inventories tokens
     *
     * @param TokenCollection $tokens
     * @return $this
     */
    private function inventory($tokens)
    {
        $this->operators = $this->operands = array();

        foreach($tokens as $token) {
            if($this->tokenType->isOperator($token)) {
                $this->operators[] = $token;
            }
            else if($this->tokenType->isOperand($token)) {
                $this->operands[] = $token;
            }
        }
        return $this;
    }

    /**
     * Calculate Halstead metrics
     *
     * @param TokenCollection $tokens
     * @return Result
     */
    public function calculate($tokens)
    {
        $this->inventory($tokens);
        $result = new Result;

        $uniqueOperators = array_map( 'unserialize', array_unique( array_map( 'serialize', $this->operators ) ) );
        $uniqueOperands = array_map( 'unserialize', array_unique( array_map( 'serialize', $this->operands ) ) );

        $n1 = sizeof($uniqueOperators, COUNT_NORMAL);
        $n2 = sizeof($uniqueOperands, COUNT_NORMAL);
        $N1 = sizeof($this->operators, COUNT_NORMAL);
        $N2 = sizeof($this->operands, COUNT_NORMAL);

        if(($n2 == 0)||($N2 == 0)||($n2 == 2)) {
            // files without operators
            $V = $n1 = $n2 = $N1 = $N2 = $E = $D = $B = $T = $I = $L = 0;
        } else {
            $devAbility = 3000;
            $N = $N1 + $N2;
            $n = $n1 + $n2;
            $V = $N * log($n ,2);
            $L = (2 / max(1,$n1)) * ($n2 / $N2);
            $D = ($n1 / 2) * ($N2 / $n2);
            $E = $V * $D;
            $B = $V / $devAbility;
            $T = $E / 18;
            $I = $L * $V;
        }

        $result
            ->setLength($N1 + $N2)
            ->setVocabulary($n1 + $n2)
            ->setVolume(round($V,2))
            ->setDifficulty(round($D,2))
            ->setEffort(round($E,2))
            ->setLevel(round($L, 2))
            ->setBugs(round($B, 2))
            ->setTime(round($T))
            ->setIntelligentContent(round($I,2))
            ->setNumberOfOperators($N1)
            ->setNumberOfOperands($N2)
            ->setNumberOfUniqueOperators($n1)
            ->setNumberOfUniqueOperands($n2)
        ;

        return $result;
    }
};
