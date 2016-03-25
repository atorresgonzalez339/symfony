<?php

/**
 * @copyright (c) 2013, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller {

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    fiendBusiness($service)
     * @see     this method get business.
     * @param   $service Name the service has example: ralf.core.business.ralfbusiness
     * @example $this->getBusiness("ralf.core.business.ralfbusiness");
     */
    public function findBusiness($service) {
        if (!$this->has($service)) {
            throw new \LogicException('The service ' . $service . ' is not configurated');
        }
        return $this->get($service);
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     */
    protected function genericNew($nameEntity, $nameFormEntity, $renderDir, $nameFormView = 'form') {
        $entity = new $nameEntity();
        $form = $this->createForm(new $nameFormEntity(), $entity);
        return $this->render($renderDir, array(
            $nameFormView => $form->createView(),
        ));
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     */
    public function genericCreate($nameEntity, $nameFormEntity, $renderDir, $nameService, $routing, $messageSucccess = '', $messageError = '', $nameFormView = 'form') {
        $request = $this->getRequest();
        $entity = new $nameEntity();
        $form = $this->createForm(new $nameFormEntity(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $this->findBusiness($nameService)->saveData($entity);
            $this->addFlash('success', $messageSucccess, $routing);
            return $this->redirect($this->generateUrl($routing));
        } else {
//            print_r('<pre>');print_r($form->getErrorsAsString());die;
            $this->addFlash('info', $messageError);
            return $this->render($renderDir, array('entity' => $entity,$nameFormView => $form->createView()));
        }
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     */
    public function genericDelete($nameService, $indexRouting,$messageInfo = '', $messageSucccess = '',$messageError = '') {
        $ids = $this->getSelectetGridItems();
        if (!$ids) {
            $this->addFlash('info', $messageInfo);
            return $this->redirect($this->generateUrl($indexRouting));
        }
        $business   = $this->findBusiness($nameService);
        $result     = $business->removeAll($ids);
        if ($result) {
            return $this->addFlash('success', $messageSucccess, $indexRouting);
        } else {
            return $this->addFlash('info', $messageError, $indexRouting);
        }
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     */
    public function getFirstSelectetGridItem() {
        $ids = $this->getSelectetGridItems();
        return $ids[0];
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     */
    public function getSelectetGridItems() {
        $request = $this->getRequest();

        $grid_key = $request->get('grid_key');
        $grid = $request->get($grid_key);

        $arrayIDs = array();

        if (isset($grid['__action'])) {

            $ids = $grid['__action'];

            foreach ($ids as $value) {
                $arrayIDs[] = $value;
            }
            return $arrayIDs;
        } else {
            return null;
        }
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    addFlash($key,$message, $route = null)
     * @see     this method add session flash and redirect.
     * @param   $key
     * @param   $message
     * @param   $route
     * @example $this->addFlash('info', 'User added', 'user_admin_index');
     */
    protected function addFlash($key, $message, $route = null,$parameters = array()) {

        if ($key != "" && $message != "") {
            $this->get('session')->start();
            $this->get('session')->getFlashBag()->add($key, $message);

            if (!is_null($route)) {
                return $this->redirect($this->generateUrl($route,$parameters));
            }
        }
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    saveSession($key, $value)
     * @see     this method save a object in the session.
     * @param   $key
     * @param   $value
     * @example $this->saveSession('security', $security);
     */
    protected function saveSession($key, $value) {

        $salt = $this->getUserAuthenticated()->getSalt();
        $ralfSession = $this->findBusiness('ralf.core.business.ralfsession')->getRepository('Core', 'RalfSession')->findByKey($key,$salt);
        $em = $this->getDoctrine()->getManager();

        if ($ralfSession) {
            $ralfSession->setKey($key);
            $ralfSession->setValue($value);
            $ralfSession->setSalt($salt);

            $em->persist($ralfSession);
        }else{
            $valueNew = str_replace('"', '\"', $value);
            //$valueNew = '"'.$valueNew.'"';
            $valueNew = serialize($valueNew);
            $this->findBusiness('ralf.core.business.ralfsession')->persist($key,$valueNew,$salt);
        }
        $em->flush();
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    getSession($key)
     * @see     this method get a object in the session by key.
     * @param   $key
     * @example $this->getSession('security');
     */
    protected function getSession($key) {

        $salt = $this->getUserAuthenticated()->getSalt();
        $ralfSession = $this->findBusiness('ralf.core.business.ralfsession')->getRepository('Core', 'RalfSession')->findByKey($key,$salt);

        if($ralfSession){
            return $ralfSession->getValue();
        }else{
            return null;
        }
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    getSession($key)
     * @see     this method remove a object in the session by key.
     * @param   $key
     * @example $this->removeSession('security');
     */
    protected function removeSession($key) {
        $peticion = $this->getRequest();
        $session = $peticion->getSession();
        return $session->remove($key);
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    getSession($key)
     * @see     This is other form to invoke a method with it's parameters
     * @param   $key
     * @example $this->invoke("ralf.security.business.user", "saveData", array($user));
     */
    protected function invoke($service, $method, array $parameters = null) {

        if (!$this->container->has($service)) {
            throw new \LogicException('The service ' . $service . ' is not configurated');
        }

        $result = null;
        $objeto = $this->container->get($service);
        $reflectionObject = new \ReflectionObject($objeto);
        $found = false;

        foreach ($reflectionObject->getMethods() as $reflectionMethod) {
            if ($reflectionMethod->getName() === $method) {
                $found = true;
                if ($parameters === null) {
                    $result = $reflectionMethod->invoke($objeto);
                } else {
                    $result = $reflectionMethod->invokeArgs($objeto, $parameters);
                }
            }
        }

        if (!$found) {
            throw new \Exception('The method ' . $method . ' is not container in the service ' . $service);
        }

        return $result;
    }

    /**
     * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
     * @name    getSession($key)
     * @see     this method remove a object in the session by key.
     * @param   $key
     * @example $this->removeSession('security');
     */
    protected function asset($path,$packageName = null) {
        return $this->get('templating.helper.assets')->getUrl($path, $packageName);
    }

}
