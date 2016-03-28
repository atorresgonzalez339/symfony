<?php

namespace DashboardBundle\Twig\Extension;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Functions extends \Twig_Extension {

    private $twig;
    private $securityContext;
    protected $container;
    protected $request;

    function __construct($twig, $securityContext, $container) {
        $this->twig = $twig;
        $this->securityContext = $securityContext;
        $this->container = $container;

        if ($this->container->isScopeActive('request')) {
            $this->request = $this->container->get('request');
        }
    }

    public function getName() {
        return 'DashboardTwigFunctions';
    }

    public function getFunctions() {
        return array(
            'request' => new \Twig_Function_Method($this, 'getParamByKeyRequest'),
            'getSession' => new \Twig_Function_Method($this, 'getSession'),
            'hasSession' => new \Twig_Function_Method($this, 'hasSession'),
            'removeSession' => new \Twig_Function_Method($this, 'removeSession'),
            'setSession' => new \Twig_Function_Method($this, 'setSession'),
        );
    }

    public function getSession($key) {
        $session = $this->request->getSession();
        return $session->get($key);
    }

    public function hasSession($key) {
        $session = $this->request->getSession();
        return $session->has($key);
    }

    public function removeSession($key) {
        $session = $this->request->getSession();
        return $session->remove($key);
    }

    public function setSession($key,$value) {
        $session = $this->request->getSession();
        return $session->set($key,$value);
    }

    public function getFilters() {
        return array(
            'parseInt' => new \Twig_Filter_Method($this, 'parseInt'),
        );
    }

    public function getParamByKeyRequest($key) {
        if($this->request->attributes->has($key)) return $this->request->attributes->get($key);
        return null;
    }

    public function parseInt($cadena) {
        return (int) $cadena;
    }
}

?>