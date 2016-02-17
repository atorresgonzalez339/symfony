<?php

namespace DashboardBundle\Twig\Extension;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Functions extends \Twig_Extension {

    private $twig;
    private $securityContext;
    protected $container;

    function __construct($twig, $securityContext, $container) {
        $this->twig = $twig;
        $this->securityContext = $securityContext;
        $this->container = $container;
    }

    public function getName() {
        return 'DashboardTwigFunctions';
    }

    public function getFunctions() {
        return array(
            'main_menu' => new \Twig_Function_Method($this, 'dd'),
        );
    }

    public function getFilters() {
        return array(
            'parseInt' => new \Twig_Filter_Method($this, 'parseInt'),
        );
    }
    
    public function parseInt($cadena) {
        return (int) $cadena;
    }
}

?>