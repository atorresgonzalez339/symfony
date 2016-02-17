<?php

namespace RALF\CommonBundle\Twig\Extension;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use \RALF\CommonBundle\Entity\ElementMenu;

class Functions extends \Twig_Extension {

    private $twig;
    private $securityContext;
    protected $container;
    private $topMenuBusiness;
    private $request;
    private $actionMenuBusiness;
    private $elementMenuBusiness;
    private $userBusiness;

    function __construct($twig, $securityContext, $container, $topMenuBusiness, $actionMenuBusiness, $userBusiness,$elementMenuBusiness) {
        $this->twig = $twig;
        $this->securityContext = $securityContext;
        $this->container = $container;
        $this->topMenuBusiness = $topMenuBusiness;
        $this->actionMenuBusiness = $actionMenuBusiness;
        $this->userBusiness = $userBusiness;
        $this->elementMenuBusiness = $elementMenuBusiness;

        if ($this->container->isScopeActive('request')) {
            $this->request = $this->container->get('request');
        }
    }

    public function getName() {
        return 'CommonTwigFunctions';
    }

    public function getFunctions() {
        return array(
            'main_menu' => new \Twig_Function_Method($this, 'mainMenu'),
            'top_menu' => new \Twig_Function_Method($this, 'topMenu'),
            'top_menu_render' => new \Twig_Function_Method($this, 'menuTreeRender'),
            'action_menu' => new \Twig_Function_Method($this, 'actionMenu'),
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

    public function mainMenu() {

        $user = $this->securityContext->getToken()->getUser();
        $roleList = $user->getRolesList();

        $idActions = array();
        foreach ($roleList as $role) {
            $actionsTemp = $role->getActions();
            foreach ($actionsTemp as $actionTemp) {
                $idActionTemp = $actionTemp->getIdaction();
                if (!isset($idActions[$idActionTemp])) {
                    $idActions[$idActionTemp] = $idActionTemp;
                }
            }
        }

        $urlController = $this->request->attributes->get('_controller');
        $aliasComponent = null;

        $parameters = explode('\\', $urlController);
        foreach ($parameters as $parameter) {
            if (strstr($parameter, 'Bundle') == 'Bundle') {
                $aliasComponent = strstr($parameter, 'Bundle', true);
            }
        }

        $topMenu = $this->topMenuBusiness->getRepository('CommonBundle', 'TopMenu')
                ->findTopMenuByComponent($aliasComponent, $user, $idActions);

        if (!$topMenu) {
            return $this->twig->render('CommonBundle:topMenu:notaction.html.twig');
        }

        $elementMenus = $topMenu->getElementMenus();

        //------------------------------------------------------------------------------------------------
        //Se agrego esto porque michel quiere que todos los menus del acordion se carguen a la vez  si se 
        //desea dejar como antes solo hay que eliminar lo que se encuentra dentro de este comentario
        //------------------------------------------------------------------------------------------------

        $topMenuProccessSecurity = array();
        $elementMenusProccessSecurity = array();

        //ELEMENT MENU ARRAY
        //[
        //  elementMenuParent   =>
        //  elementMenuChilds   =>
        //  idelementmenu       =>
        //  denomination        =>
        //  route               =>
        //  icon                =>
        //  visibility          =>
        //]
        //-->>>>>>>> NIVEL I DEL ARBOL

        foreach ($elementMenus as $element) {

            if (!$element->getElementMenuParent()) {
                $elementMenusProccessSecurity['elementMenuParent'] = null;
//            $elementMenusProccessSecurity['elementMenuChilds']  = null;
                $elementMenusProccessSecurity['idelementmenu'] = $element->getIdelementmenu();
                $elementMenusProccessSecurity['denomination'] = $element->getDenomination();
                $elementMenusProccessSecurity['icon'] = $element->getIcon();
                $elementMenusProccessSecurity['visibility'] = $element->getVisibility();
                $elementMenusProccessSecurity['action'] = $element->getAction(); //$element->getAction() ?$this->container->get('router')->generate($element->getAction()->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH):null;

                $childs = $element->getElementMenuChilds();

                $elementMenusProccessSecurityChilds = array();

                //-->>>>>>>> NIVEL II DEL ARBOL
                foreach ($childs as $key => $child) {

                    $action = $child->getAction();

                    if ($action || $this->isChildsAccess($idActions, $child->getElementMenuChilds())) {

                        $elementMenusProccessSecurityChild = array();
                        $elementMenusProccessSecurityParent = array();

                        $elementMenusProccessSecurityParent['elementMenuParent'] = $elementMenusProccessSecurity['elementMenuParent'];
                        $elementMenusProccessSecurityParent['idelementmenu'] = $elementMenusProccessSecurity['idelementmenu'];
                        $elementMenusProccessSecurityParent['denomination'] = $elementMenusProccessSecurity['denomination'];
                        $elementMenusProccessSecurityParent['action'] = $elementMenusProccessSecurity['action'];
                        $elementMenusProccessSecurityParent['icon'] = $elementMenusProccessSecurity['icon'];
                        $elementMenusProccessSecurityParent['visibility'] = $elementMenusProccessSecurity['visibility'];

                        $elementMenusProccessSecurityChild['elementMenuParent'] = $elementMenusProccessSecurityParent;
                        $elementMenusProccessSecurityChild['idelementmenu'] = $child->getIdelementmenu();
                        $elementMenusProccessSecurityChild['denomination'] = $child->getDenomination();
                        $elementMenusProccessSecurityChild['icon'] = $child->getIcon();
                        $elementMenusProccessSecurityChild['visibility'] = $child->getVisibility();
                        $elementMenusProccessSecurityChild['action'] = $child->getAction(); //$child->getAction()?$this->container->get('router')->generate($child->getAction()->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH):null;


                        $childsIII = $child->getElementMenuChilds();
                        $elementMenusProccessSecurityChildsIII = array();

                        //-->>>>>>>> NIVEL III DEL ARBOL
                        foreach ($childsIII as $childIII) {
                            $actionIII = $childIII->getAction();

                            if ($actionIII) {
                                $idActionIII = $actionIII->getIdaction();

                                if (isset($idActions[$idActionIII])) {

                                    $elementMenusProccessSecurityChildIII = array();
                                    $elementMenusProccessSecurityParentIII = array();

                                    $elementMenusProccessSecurityParentIII['elementMenuParent'] = $elementMenusProccessSecurityParent['elementMenuParent'];
                                    $elementMenusProccessSecurityParentIII['idelementmenu'] = $elementMenusProccessSecurityParent['idelementmenu'];
                                    $elementMenusProccessSecurityParentIII['denomination'] = $elementMenusProccessSecurityParent['denomination'];
                                    $elementMenusProccessSecurityParentIII['action'] = $elementMenusProccessSecurityParent['action'];
                                    $elementMenusProccessSecurityParentIII['icon'] = $elementMenusProccessSecurityParent['icon'];
                                    $elementMenusProccessSecurityParentIII['visibility'] = $elementMenusProccessSecurityParent['visibility'];

                                    $elementMenusProccessSecurityChildIII['elementMenuParent'] = $elementMenusProccessSecurityParentIII;
                                    $elementMenusProccessSecurityChildIII['idelementmenu'] = $childIII->getIdelementmenu();
                                    $elementMenusProccessSecurityChildIII['denomination'] = $childIII->getDenomination();
                                    $elementMenusProccessSecurityChildIII['icon'] = $childIII->getIcon();
                                    $elementMenusProccessSecurityChildIII['visibility'] = $childIII->getVisibility();
                                    $elementMenusProccessSecurityChildIII['elementMenuChilds'] = null;
                                    $elementMenusProccessSecurityChildIII['action'] = $childIII->getAction(); //$this->container->get('router')->generate($childIII->getAction()->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH);

                                    $elementMenusProccessSecurityChildsIII[] = $elementMenusProccessSecurityChildIII;
                                }
                            }
                        }

                        $elementMenusProccessSecurityChild['elementMenuChilds'] = $elementMenusProccessSecurityChildsIII;

                        $elementMenusProccessSecurityChilds [] = $elementMenusProccessSecurityChild;
                    }
                }
                $elementMenusProccessSecurity['elementMenuChilds'] = $elementMenusProccessSecurityChilds;
                $topMenuProccessSecurity[] = $elementMenusProccessSecurity;
            }
        }
        //------------------------------------------------------------------------------------------------
//        echo '<pre>';
//        print_r($topMenuProccessSecurity);
//        die;
        
        $template = 'CommonBundle:topMenu:index.html.twig';
        return $this->twig->render($template, array(
                    'elementMenus' => $topMenuProccessSecurity,
        ));
    }


    public function topMenu() {

        $user = $this->securityContext->getToken()->getUser();
        $roleList = $user->getRolesList();

        $idActions = array();
        foreach ($roleList as $role) {
            $actionsTemp = $role->getActions();
            foreach ($actionsTemp as $actionTemp) {
                $idActionTemp = $actionTemp->getIdaction();
                if (!isset($idActions[$idActionTemp])) {
                    $idActions[$idActionTemp] = $idActionTemp;
                }
            }
        }

        $urlController = $this->request->attributes->get('_controller');
        $aliasComponent = null;

        $parameters = explode('\\', $urlController);
        foreach ($parameters as $parameter) {
            if (strstr($parameter, 'Bundle') == 'Bundle') {
                $aliasComponent = strstr($parameter, 'Bundle', true);
            }
        }

        $topMenu = $this->topMenuBusiness->getRepository('CommonBundle', 'TopMenu')
                ->findTopMenuByComponent($aliasComponent, $user, $idActions);

        if (!$topMenu) {
            return $this->twig->render('CommonBundle:topMenu:notaction.html.twig');
        }

        $elementMenus = $topMenu->getElementMenus();

        //------------------------------------------------------------------------------------------------
        //Se agrego esto porque michel quiere que todos los menus del acordion se carguen a la vez  si se 
        //desea dejar como antes solo hay que eliminar lo que se encuentra dentro de este comentario
        //------------------------------------------------------------------------------------------------

        $topMenuProccessSecurity = array();
        $elementMenusProccessSecurity = array();

        //ELEMENT MENU ARRAY
        //[
        //  elementMenuParent   =>
        //  elementMenuChilds   =>
        //  idelementmenu       =>
        //  denomination        =>
        //  route               =>
        //  icon                =>
        //  visibility          =>
        //]
        //-->>>>>>>> NIVEL I DEL ARBOL

        foreach ($elementMenus as $element) {

            if (!$element->getElementMenuParent()) {
                $elementMenusProccessSecurity['elementMenuParent'] = null;
//            $elementMenusProccessSecurity['elementMenuChilds']  = null;
                $elementMenusProccessSecurity['idelementmenu'] = $element->getIdelementmenu();
                $elementMenusProccessSecurity['denomination'] = $element->getDenomination();
                $elementMenusProccessSecurity['icon'] = $element->getIcon();
                $elementMenusProccessSecurity['visibility'] = $element->getVisibility();
                $elementMenusProccessSecurity['action'] = $element->getAction(); //$element->getAction() ?$this->container->get('router')->generate($element->getAction()->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH):null;

                $childs = $element->getElementMenuChilds();

                $elementMenusProccessSecurityChilds = array();

                //-->>>>>>>> NIVEL II DEL ARBOL
                foreach ($childs as $key => $child) {

                    $action = $child->getAction();

                    if ($action || $this->isChildsAccess($idActions, $child->getElementMenuChilds())) {

                        $elementMenusProccessSecurityChild = array();
                        $elementMenusProccessSecurityParent = array();

                        $elementMenusProccessSecurityParent['elementMenuParent'] = $elementMenusProccessSecurity['elementMenuParent'];
                        $elementMenusProccessSecurityParent['idelementmenu'] = $elementMenusProccessSecurity['idelementmenu'];
                        $elementMenusProccessSecurityParent['denomination'] = $elementMenusProccessSecurity['denomination'];
                        $elementMenusProccessSecurityParent['action'] = $elementMenusProccessSecurity['action'];
                        $elementMenusProccessSecurityParent['icon'] = $elementMenusProccessSecurity['icon'];
                        $elementMenusProccessSecurityParent['visibility'] = $elementMenusProccessSecurity['visibility'];

                        $elementMenusProccessSecurityChild['elementMenuParent'] = $elementMenusProccessSecurityParent;
                        $elementMenusProccessSecurityChild['idelementmenu'] = $child->getIdelementmenu();
                        $elementMenusProccessSecurityChild['denomination'] = $child->getDenomination();
                        $elementMenusProccessSecurityChild['icon'] = $child->getIcon();
                        $elementMenusProccessSecurityChild['visibility'] = $child->getVisibility();
                        $elementMenusProccessSecurityChild['action'] = $child->getAction(); //$child->getAction()?$this->container->get('router')->generate($child->getAction()->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH):null;


                        $childsIII = $child->getElementMenuChilds();
                        $elementMenusProccessSecurityChildsIII = array();

                        //-->>>>>>>> NIVEL III DEL ARBOL
                        foreach ($childsIII as $childIII) {
                            $actionIII = $childIII->getAction();

                            if ($actionIII) {
                                $idActionIII = $actionIII->getIdaction();

                                if (isset($idActions[$idActionIII])) {

                                    $elementMenusProccessSecurityChildIII = array();
                                    $elementMenusProccessSecurityParentIII = array();

                                    $elementMenusProccessSecurityParentIII['elementMenuParent'] = $elementMenusProccessSecurityParent['elementMenuParent'];
                                    $elementMenusProccessSecurityParentIII['idelementmenu'] = $elementMenusProccessSecurityParent['idelementmenu'];
                                    $elementMenusProccessSecurityParentIII['denomination'] = $elementMenusProccessSecurityParent['denomination'];
                                    $elementMenusProccessSecurityParentIII['action'] = $elementMenusProccessSecurityParent['action'];
                                    $elementMenusProccessSecurityParentIII['icon'] = $elementMenusProccessSecurityParent['icon'];
                                    $elementMenusProccessSecurityParentIII['visibility'] = $elementMenusProccessSecurityParent['visibility'];

                                    $elementMenusProccessSecurityChildIII['elementMenuParent'] = $elementMenusProccessSecurityParentIII;
                                    $elementMenusProccessSecurityChildIII['idelementmenu'] = $childIII->getIdelementmenu();
                                    $elementMenusProccessSecurityChildIII['denomination'] = $childIII->getDenomination();
                                    $elementMenusProccessSecurityChildIII['icon'] = $childIII->getIcon();
                                    $elementMenusProccessSecurityChildIII['visibility'] = $childIII->getVisibility();
                                    $elementMenusProccessSecurityChildIII['elementMenuChilds'] = null;
                                    $elementMenusProccessSecurityChildIII['action'] = $childIII->getAction(); //$this->container->get('router')->generate($childIII->getAction()->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH);

                                    $elementMenusProccessSecurityChildsIII[] = $elementMenusProccessSecurityChildIII;
                                }
                            }
                        }

                        $elementMenusProccessSecurityChild['elementMenuChilds'] = $elementMenusProccessSecurityChildsIII;

                        $elementMenusProccessSecurityChilds [] = $elementMenusProccessSecurityChild;
                    }
                }
                $elementMenusProccessSecurity['elementMenuChilds'] = $elementMenusProccessSecurityChilds;
                $topMenuProccessSecurity[] = $elementMenusProccessSecurity;
            }
        }
        //------------------------------------------------------------------------------------------------
//        echo '<pre>';
//        print_r($topMenuProccessSecurity);
//        die;

        return $this->twig->render('CommonBundle:topMenu:index.html.twig', array(
                    'elementMenus' => $topMenuProccessSecurity,
        ));
    }

    public function isChildsAccess($idActions, $childs) {
        foreach ($childs as $child) {
            $action = $child->getAction();
            if ($action) {
                $idAction = $action->getIdaction();

                if (isset($idActions[$idAction])) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function menuTreeRender(ElementMenu $elementMenu, $idActions) {

        $parent = $elementMenu->getElementMenuParent();
        $childs = $elementMenu->getElementMenuChilds();

        if (count($childs) == 0) {
            $action = $elementMenu->getAction();

            if ($action) {
                $idAction = $action->getIdaction();

                if (isset($idActions[$idAction])) {

                    $url = $this->container->get('router')->generate($action->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH);
                    $icon = $elementMenu->getIcon() ? '<i class="' . $elementMenu->getIcon() . '"></i> ' : '';
                    $submenu = '';
                    $submenu .= '<li class="dropdown">';
                    $submenu .= '<a id=item-' . $elementMenu->getIdelementmenu() . ' href="' . $url . '">' . $icon . $elementMenu->getDenomination() . '</a>';
                    $submenu .= '</li>';

                    return $submenu;
                }

                return false;
            }

            return false;
        }

        $carret = !$parent ? '<span class="caret"></span>' : '';
        $toogle = !$parent ? 'data-toggle="dropdown"' : '';
        $actionParent = $elementMenu->getAction();
        $url = !$actionParent ? '#' : $this->container->get('router')->generate($actionParent->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH);
        $icon = $elementMenu->getIcon() ? '<i class="' . $elementMenu->getIcon() . '"></i> ' : '';
        $linkParent = '<a class="dropdown-toggle" href="' . $url . '" ' . $toogle . '>' . $icon . $elementMenu->getDenomination() . $carret . '</a>';
        $submenu = '<ul class="dropdown-menu" role="menu">';

        $count = 0;

        foreach ($childs as $child) {

            $subTreeElement = $this->menuTreeRender($child, $idActions);

            if ($subTreeElement === true) {
                $actionChild = $child->getAction();
                $url = $this->container->get('router')->generate($actionChild->getRoute(), array(), UrlGeneratorInterface::ABSOLUTE_PATH);
                $icon = $child->getIcon() ? '<i class="' . $child->getIcon() . '"></i> ' : '';
                $submenu .= '<li class="dropdown">';
                $submenu .= '<a href="' . $url . '">' . $icon . $child->getDenomination() . '</a>';
                $submenu .= '</li>';
                $count++;
            } elseif ($subTreeElement === false) {
                $submenu .= '';
            } else {
                $submenu .= '<li class="dropdown-submenu">';
                $submenu .= $subTreeElement;
                $submenu .= '</li>';
                $count++;
            }
        }

        $submenu .= '</ul>';

        return $count > 0 ? $linkParent . $submenu : $submenu;
    }

    public function actionMenu($viewmenu = null, $idFormSubmit = null) {
        
        $user = $this->securityContext->getToken()->getUser();
        $urlController = $this->request->attributes->get('_controller');

        $aliasComponent = null;
        $aliasFuncionality = null;
        $aliasAction = null;

        $parameters = explode('::', $urlController);
        $items = explode('\\', $parameters[0]);

        foreach ($items as $item) {
            if (strstr($item, 'Bundle') == 'Bundle') {
                $aliasComponent = strstr($item, 'Bundle', true);
            }

            if (strstr($item, 'Controller') == 'Controller') {
                $aliasFuncionality = strstr($item, 'Controller', true);
            }
        }

        if (strstr($parameters[1], 'Action') == 'Action') {
            $aliasAction = strstr($parameters[1], 'Action', true);
        }

        $viewmenu = $viewmenu == null ? $aliasAction : $viewmenu;

//        echo '<pre>';
//        print_r($aliasComponent.'<br>');
//        print_r($aliasFuncionality.'<br>');
//        print_r($aliasAction.'<br>');
//        print_r($viewmenu.'<br>');
//        die;
        
        
        $isBrotherAction = $this->container->getParameter('admin.brother.action.config');
        $brothersElementMenu = null;
        
        if ($isBrotherAction) {
            $brothersElementMenu = $this->elementMenuBusiness->getRepository('CommonBundle', 'ElementMenu')
                              ->findBrotherElementMenu($aliasFuncionality,$aliasAction);
        }
        
        $brothersElementMenuProccess = array();
        if($brothersElementMenu){
        foreach ($brothersElementMenu as $item) {
            $itemNew['icon']         = $item['icon'];
            $itemNew['route']        = $item['action']['route'];
            $itemNew['denomination'] = $item['denomination'];
            
            if($item['action']['functionality']['denomination'] == $aliasFuncionality){
                $itemNew['active'] = true;
            }else{
                $itemNew['active'] = false;
            }
            $brothersElementMenuProccess[]=$itemNew;
            
        }
        }
//        echo '<pre>';
//        print_r($brothersElementMenuProccess);
//        die;

        $actionMenu = $this->actionMenuBusiness->getRepository('CommonBundle', 'ActionMenu')
                ->findActionMenuByCFAU($aliasFuncionality, $user, $viewmenu);

        return $this->twig->render('CommonBundle:actionMenu:index.html.twig', array(
                    'actionMenu' => $actionMenu,
                    'idFormSubmit' => $idFormSubmit,
                    'brothersElementMenu' => $brothersElementMenuProccess,
                    'isBrotherAction' => $isBrotherAction,
        ));
    }

}

?>