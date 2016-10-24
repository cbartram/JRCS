<?php

/*
 * (c) Jean-François Lépine <https://twitter.com/Halleck45>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hal\Component\OOP\Extractor;
use Hal\Component\OOP\Reflected\ReflectedClass;
use Hal\Component\OOP\Reflected\ReflectedInterface;
use Hal\Component\Result\ExportableInterface;


/**
 * Result
 *
 * @author Jean-François Lépine <https://twitter.com/Halleck45>
 */
class Result implements ExportableInterface {

    /**
     * @var array
     */
    private $classes = array();

    /**
     * @inheritdoc
     */
    public function asArray() {

        $nom = 0;
        foreach($this->getClasses() as $class) {
            $nom += sizeof($class->getMethods(), COUNT_NORMAL);
        }

        return array(
            'noc' => sizeof($this->classes, COUNT_NORMAL)
            , 'noca' => sizeof($this->getAbstractClasses(), COUNT_NORMAL)
            , 'nocc' => sizeof($this->getConcreteClasses(), COUNT_NORMAL)
            , 'noc-anon' => sizeof($this->getAnonymousClasses(), COUNT_NORMAL)
            , 'noi' => sizeof($this->getInterfaces(), COUNT_NORMAL)
            , 'nom' => $nom
        );
    }

    /**
     * Push class
     *
     * @param ReflectedClass $class
     * @return $this
     */
    public function pushClass(ReflectedClass $class) {
        array_push($this->classes, $class);
        return $this;
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Get abstract classes
     *
     * @return array
     */
    public function getAbstractClasses() {
        $result = array();
        foreach($this->getClasses() as $class) {
            if($class->isAbstract() ||$class instanceof ReflectedInterface) {
                array_push($result, $class);
            }
        }
        return $result;
    }

    /**
     * Get anonymous classes
     *
     * @return array
     */
    public function getAnonymousClasses() {
        $result = array();
        foreach($this->getClasses() as $class) {
            if($class instanceof ReflectedClass\ReflectedAnonymousClass) {
                array_push($result, $class);
            }
        }
        return $result;
    }

    /**
     * Get abstract classes
     *
     * @return array
     */
    public function getInterfaces() {
        $result = array();
        foreach($this->getClasses() as $class) {
            if($class instanceof ReflectedInterface) {
                array_push($result, $class);
            }
        }
        return $result;
    }

    /**
     * Get concretes classes
     *
     * @return array
     */
    public function getConcreteClasses() {
        $result = array();
        foreach($this->getClasses() as $class) {
            if(!$class->isAbstract() &&!$class instanceof ReflectedInterface  && !$class instanceof ReflectedClass\ReflectedAnonymousClass) {
                array_push($result, $class);
            }
        }
        return $result;
    }
}