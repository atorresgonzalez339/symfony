<?php

/**
 * @copyright (c) 2013, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace CommonBundle\Aop;

use Doctrine\Common\Annotations\Reader;
use JMS\AopBundle\Aop\PointcutInterface;


class TransactionPointcut implements PointcutInterface {

    private $reader;

    function __construct(Reader $reader) {
        $this->reader = $reader;
    }

    public function matchesClass(\ReflectionClass $class) {
        return false !== strpos($class->name, 'Business');
    }

    public function matchesMethod(\ReflectionMethod $method) {
        return null !== $this->reader->getMethodAnnotation($method, 'CommonBundle\Annotations\Transactional');
    }

}

