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
        );
    }

    public function getFilters() {
        return array(
            'parseInt' => new \Twig_Filter_Method($this, 'parseInt'),
        );
    }

    public function getParamByKeyRequest($key) {
//         $this->request->attributes->set('propert_id',11);
        return $this->request->get($key);
    }

    public function parseInt($cadena) {
        return (int) $cadena;
    }
}

?>