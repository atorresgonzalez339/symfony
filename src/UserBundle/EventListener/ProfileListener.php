<?php

namespace UserBundle\EventListener;

use CommonBundle\Business\BaseBusiness;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use UserBundle\Controller\ProfileController;

class ProfileListener extends BaseBusiness
{

  protected $security_context;
  protected $router;

  public function __construct($em, $security_context, $router) {
    parent::__construct($em);
    $this->security_context = $security_context;
    $this->router = $router;
  }

  public function onKernelRequest(GetResponseEvent $event)
  {
    $route = $event->getRequest()->get('_route');
    $pattern = 'profile';
    $isProfilePath = strpos($route, $pattern);
    $isAjaxRequest = $event->getRequest()->isXmlHttpRequest();

    if ($isProfilePath === false && $isAjaxRequest == false && $this->security_context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        $user = $this->security_context->getToken()->getUser();

        if (!$user->getProfile()->getIsCompleted()) {
          $url = $this->router->generate('profile_index');
          $event->setResponse(new RedirectResponse($url));
        }
    }
  }
}