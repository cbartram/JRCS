<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\OOP\Reflected;
use Hal\Component\OOP\Reflected\ReflectedClass\ReflectedAnonymousClass;
use Hal\Component\OOP\Resolver\NameResolver;
use Hal\Component\OOP\Resolver\TypeResolver;


/**
 * Result (method)
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class ReflectedMethod {

    CONST VISIBILITY_PUBLIC = 'public';
    CONST VISIBILITY_PRIVATE = 'private';
    CONST VISIBILITY_PROTECTED = 'protected';
    CONST STATE_LOCAL = 1;
    CONST STATE_STATIC = 2;


    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @var array
     */
    private $returns = array();

    /**
     * @var array
     */
    private $dependencies = array();

    /**
     * Resolver for names
     *
     * @var NameResolver
     */
    private $nameResolver;

    /**
     * @var array
     */
    private $tokens = array();

    /**
     * @var string
     */
    private $content;

    /**
     * Usage of method (getter, setter...)
     *
     * @var string
     */
    private $usage;

    /**
     * @var int
     */
    private $visibility = self::VISIBILITY_PUBLIC;

    /**
     * @var int
     */
    private $state = self::STATE_LOCAL;

    /**
     * Anonymous class contained in this method
     *
     * @var array
     */
    private $anonymousClasses = array();

    /**
     * @var array
     */
    private $instanciedClasses = array();

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var array
     */
    private $internalCalls = array();

    /**
     * @var array
     */
    private $externalCalls = array();

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = (string) $name;
        $this->nameResolver = new NameResolver();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Attach argument
     *
     * @param ReflectedArgument $arg
     * @return $this
     */
    public function pushArgument(ReflectedArgument $arg) {
        array_push($this->arguments, $arg);
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return TokenCollection
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param \Hal\Component\Token\TokenCollection $tokens
     * @return $this
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
        return $this;
    }

    /**
     * Get returned value
     *
     * @return array
     */
    public function getReturns() {
        // on read : compare with aliases. We cannot make it in pushDependency() => aliases aren't yet known
        $result = array();
        $resolver = new TypeResolver();
        foreach($this->returns as $return) {
            $type = $this->nameResolver->resolve($return->getType(), null);

            if("\\" !== $type[0] &&!$resolver->isNative($type)) {
                $type = $this->namespace.'\\'.$type;
            }

            $return->setType($type);
            $result[] = $return;
        }
        return array_values($result);
    }

    /**
     * Attach ne return information
     *
     *      It make no sense for the moment to store any information abour return value / type. Maybe in PHP 6 ? :)
     *
     * @param ReflectedReturn $return
     * @return $this
     */
    public function pushReturn(ReflectedReturn $return) {
        array_push($this->returns, $return);
        return $this;
    }

    /**
     * Push dependency
     *
     * @param $name
     * @return self
     */
    public function pushDependency($name) {
        array_push($this->dependencies, $name);
        return $this;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        // on read : compare with aliases. We cannot make it in pushDependency() => aliases aren't yet known
        $dependencies = array();
        foreach($this->dependencies as $name) {
            array_push($dependencies, $this->nameResolver->resolve($name, null));
        }

        // returned values
        $resolver = new TypeResolver();
        foreach($this->returns as $return) {
            $name = $return->getType();
            if(!$resolver->isNative($name)) {
                array_push($dependencies, $this->nameResolver->resolve($name, null));
            }
        }

        // anonymous classes in method (inner class)
        foreach($this->anonymousClasses as $c) {
            array_push($dependencies, $c->getParent());
            $dependencies = array_merge($dependencies, $c->getDependencies());
        }
        return array_unique($dependencies);
    }

    /**
     * @param NameResolver $resolver
     * @return self
     */
    public function setNameResolver(NameResolver $resolver)
    {
        $this->nameResolver = $resolver;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSetter() {
        return MethodUsage::USAGE_SETTER == $this->getUsage();
    }

    /**
     * @return string
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param string $usage
     */
    public function setUsage($usage)
    {
        $this->usage = $usage;
    }

    /**
     * @return bool
     */
    public function isGetter() {
        return MethodUsage::USAGE_GETTER == $this->getUsage();
    }

    /**
     * @return int
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param int $visibility
     * @return $this
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $state
     * @return ReflectedMethod
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    /**
     * @param ReflectedAnonymousClass $class
     * @return $this
     */
    public function pushAnonymousClass(ReflectedAnonymousClass $class) {
        $this->anonymousClasses[] = $class;
        return $this;
    }

    /**
     * @return array
     */
    public function getAnonymousClasses()
    {
        return $this->anonymousClasses;
    }

    /**
     * @param string $namespace
     * @return ReflectedMethod
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param $class
     * @return $this
     */
    public function pushInstanciedClass($class) {
        $this->instanciedClasses[] = $class;
        return $this;
    }

    /**
     * @return array
     */
    public function getInstanciedClasses()
    {
        $classes = array();
        foreach($this->instanciedClasses as $name) {
            array_push($classes, $this->nameResolver->resolve($name, null));
        }
        return $classes;
    }

    /**
     * @param $call
     * @return $this
     */
    public function pushInternalCall($call)
    {
        $this->internalCalls[] = $call;
        return $this;
    }

    /**
     * @return array
     */
    public function getInternalCalls()
    {
        return $this->internalCalls;
    }

    /**
     * @param $call
     * @return $this
     */
    public function pushExternalCall($call)
    {
        $this->externalCalls[] = $call;
        return $this;
    }

    /**
     * @return array
     */
    public function getExternalCalls()
    {
        return $this->externalCalls;
    }



};