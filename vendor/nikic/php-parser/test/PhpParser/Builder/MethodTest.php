<?php

namespace PhpParser\Builder;

use PhpParser\Node;
use PhpParser\Node\Expr\Print_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Comment;

class MethodTest extends \PHPUnit_Framework_TestCase
{
    public function createMethodBuilder($name) {
        return new Method($name);
    }

    public function testModifiers() {
        $node = $this->createMethodBuilder('tests')
            ->makePublic()
            ->makeAbstract()
            ->makeStatic()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\ClassMethod('tests', array(
                'type' => Stmt\Class_::MODIFIER_PUBLIC
                        | Stmt\Class_::MODIFIER_ABSTRACT
                        | Stmt\Class_::MODIFIER_STATIC,
                'stmts' => null,
            )),
            $node
        );

        $node = $this->createMethodBuilder('tests')
            ->makeProtected()
            ->makeFinal()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\ClassMethod('tests', array(
                'type' => Stmt\Class_::MODIFIER_PROTECTED
                        | Stmt\Class_::MODIFIER_FINAL
            )),
            $node
        );

        $node = $this->createMethodBuilder('tests')
            ->makePrivate()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\ClassMethod('tests', array(
                'type' => Stmt\Class_::MODIFIER_PRIVATE
            )),
            $node
        );
    }

    public function testReturnByRef() {
        $node = $this->createMethodBuilder('tests')
            ->makeReturnByRef()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\ClassMethod('tests', array(
                'byRef' => true
            )),
            $node
        );
    }

    public function testParams() {
        $param1 = new Node\Param('test1');
        $param2 = new Node\Param('test2');
        $param3 = new Node\Param('test3');

        $node = $this->createMethodBuilder('tests')
            ->addParam($param1)
            ->addParams(array($param2, $param3))
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\ClassMethod('tests', array(
                'params' => array($param1, $param2, $param3)
            )),
            $node
        );
    }

    public function testStmts() {
        $stmt1 = new Print_(new String_('test1'));
        $stmt2 = new Print_(new String_('test2'));
        $stmt3 = new Print_(new String_('test3'));

        $node = $this->createMethodBuilder('tests')
            ->addStmt($stmt1)
            ->addStmts(array($stmt2, $stmt3))
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\ClassMethod('tests', array(
                'stmts' => array($stmt1, $stmt2, $stmt3)
            )),
            $node
        );
    }
    public function testDocComment() {
        $node = $this->createMethodBuilder('tests')
            ->setDocComment('/** Test */')
            ->getNode();

        $this->assertEquals(new Stmt\ClassMethod('tests', array(), array(
            'comments' => array(new Comment\Doc('/** Test */'))
        )), $node);
    }

    public function testReturnType() {
        $node = $this->createMethodBuilder('tests')
            ->setReturnType('bool')
            ->getNode();
        $this->assertEquals(new Stmt\ClassMethod('tests', array(
            'returnType' => 'bool'
        ), array()), $node);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cannot add statements to an abstract method
     */
    public function testAddStmtToAbstractMethodError() {
        $this->createMethodBuilder('tests')
            ->makeAbstract()
            ->addStmt(new Print_(new String_('tests')))
        ;
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cannot make method with statements abstract
     */
    public function testMakeMethodWithStmtsAbstractError() {
        $this->createMethodBuilder('tests')
            ->addStmt(new Print_(new String_('tests')))
            ->makeAbstract()
        ;
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Expected parameter node, got "Name"
     */
    public function testInvalidParamError() {
        $this->createMethodBuilder('tests')
            ->addParam(new Node\Name('foo'))
        ;
    }
}
