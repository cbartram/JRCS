<?php
namespace Test\Hal\Component\Token;

use Hal\Component\Token\TokenType;

/**
 * @group token
 */
class TokenTypeTest extends \PHPUnit_Framework_TestCase {

    private $object;

    public function setup() {
        $this->object = new TokenType();
    }

    /**
     * @dataProvider providesTokenTypes
     */
    public function testTokenTypeDistinguishsTokens($isOperator, $isOperand, $type, $value) {

        $token = $this->getMockBuilder('\Hal\Component\Token\Token')
            ->disableOriginalConstructor()
            ->getMock();
        $token->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($type));
        $token->expects($this->any())
            ->method('getValue')
            ->will($this->returnValue($value));

        $this->assertEquals($isOperator, $this->object->isOperator($token));
        $this->assertEquals($isOperand, $this->object->isOperand($token));
    }

    public function providesTokenTypes() {
        return array(
            array(true, false, T_BOOLEAN_AND, '&&')
            , array(true, false, T_BOOLEAN_AND, '&&')
            , array(false, true, T_VARIABLE, '$a')

            // operators
            , array(true, false, T_STRING, ';')
            , array(true, false, T_STRING, '*')
            , array(true, false, T_STRING, '#')
            , array(true, false, T_STRING, '[')
            , array(true, false, T_STRING, '>>')
            , array(true, false, T_STRING, '!')
            , array(true, false, T_STRING, '+')
            , array(true, false, T_STRING, '?')
            , array(true, false, T_STRING, '!=')
            , array(true, false, T_STRING, '%')
            , array(true, false, T_STRING, '&')
            , array(true, false, T_STRING, '&&')
            , array(true, false, T_STRING, '/')
        );
    }
}