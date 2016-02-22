<?php

/**
 * @copyright (c) 2013, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace CommonBundle\Aop;

use CG\Proxy\MethodInterceptorInterface;
use CG\Proxy\MethodInvocation;
use Doctrine\ORM\EntityManager;

class TransactionInterceptor implements MethodInterceptorInterface {

    private $em;

    function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function intercept(MethodInvocation $invocation) {

        $this->em->getConnection()->beginTransaction();

        try {
            $rs = $invocation->proceed();
            $this->em->flush();
            $this->em->getConnection()->commit();
            return $rs;
        } catch (\Exception $ex) {
            $this->em->close();
            $this->em->getConnection()->rollBack();
            throw $ex;
        }
    }

}

