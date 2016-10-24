<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\Token;

/**
 * Representation of Token
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class Token {
    /**
     * Type of token
     *
     * @var integer
     */
    private $type;

    /**
     * Value of token
     *
     * @var string
     */
    private $value;

    /**
     * Constructor
     * @param string|array $data
     */
    public function __construct($data)
    {
        if(!is_array($data)) {
            $this->type = T_STRING;
            $this->value = $data;
        } else {
            $this->type = $data[0];
            $this->value = isset($data[1]) ? $data[1] : null;
        }

        // reduce multiple spaces to one
        if(T_WHITESPACE  === $this->type && preg_match('/^\s*$/', $this->value)) {
            $this->value = ' ';
        }
    }

    /**
     * Get the type of token
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get value of token
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * String representation
     *
     * @return integer
     */
    public function asString() {
        return $this->getValue();
    }

}