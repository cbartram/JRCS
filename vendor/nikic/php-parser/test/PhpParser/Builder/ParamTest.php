<?php

namespace PhpParser\Builder;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;

class ParamTest extends \PHPUnit_Framework_TestCase
{
    public function createParamBuilder($name) {
        return new Param($name);
    }

    /**
     * @dataProvider provideTestDefaultValues
     */
    public function testDefaultValues($value, $expectedValueNode) {
        $node = $this->createParamBuilder('tests')
            ->setDefault($value)
            ->getNode()
        ;

        $this->assertEquals($expectedValueNode, $node->default);
    }

    public function provideTestDefaultValues() {
        return array(
            array(
                null,
                new Expr\ConstFetch(new Node\Name('null'))
            ),
            array(
                true,
                new Expr\ConstFetch(new Node\Name('true'))
            ),
            array(
                false,
                new Expr\ConstFetch(new Node\Name('false'))
            ),
            array(
                31415,
                new Scalar\LNumber(31415)
            ),
            array(
                3.1415,
                new Scalar\DNumber(3.1415)
            ),
            array(
                'Hallo World',
                new Scalar\String_('Hallo World')
            ),
            array(
                array(1, 2, 3),
                new Expr\Array_(array(
                    new Expr\ArrayItem(new Scalar\LNumber(1)),
                    new Expr\ArrayItem(new Scalar\LNumber(2)),
                    new Expr\ArrayItem(new Scalar\LNumber(3)),
                ))
            ),
            array(
                array('foo' => 'bar', 'bar' => 'foo'),
                new Expr\Array_(array(
                    new Expr\ArrayItem(
                        new Scalar\String_('bar'),
                        new Scalar\String_('foo')
                    ),
                    new Expr\ArrayItem(
                        new Scalar\String_('foo'),
                        new Scalar\String_('bar')
                    ),
                ))
            ),
            array(
                new Scalar\MagicConst\Dir,
                new Scalar\MagicConst\Dir
            )
        );
    }

    public function testTypeHints() {
        $node = $this->createParamBuilder('tests')
            ->setTypeHint('array')
            ->getNode()
        ;

        $this->assertEquals(
            new Node\Param('tests', null, 'array'),
            $node
        );

        $node = $this->createParamBuilder('tests')
            ->setTypeHint('callable')
            ->getNode()
        ;

        $this->assertEquals(
            new Node\Param('tests', null, 'callable'),
            $node
        );

        $node = $this->createParamBuilder('tests')
            ->setTypeHint('Some\Class')
            ->getNode()
        ;

        $this->assertEquals(
            new Node\Param('tests', null, new Node\Name('Some\Class')),
            $node
        );
    }

    public function testByRef() {
        $node = $this->createParamBuilder('tests')
            ->makeByRef()
            ->getNode()
        ;

        $this->assertEquals(
            new Node\Param('tests', null, null, true),
            $node
        );
    }
}
