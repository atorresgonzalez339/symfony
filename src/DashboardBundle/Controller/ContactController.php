<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class ContactController extends BaseController{

    private $nameEntity     = '\DashboardBundle\Entity\Contact';
    private $nameFormEntity = '\DashboardBundle\Form\ContactType';
    private $nameService    = 'dashboard.contact.business';
    private $indexRouting   = 'contact_index';
    private $newRouting     = 'contact_new';

    public function getBusiness() {
        return parent::findBusiness($this->nameService);
    }

  /**
   * @Route("/contacts", name="contact_index")
   */
    public function indexAction(Request $request){
      $source = new Entity('DashboardBundle:Contact');
      $grid = $this->get('grid');
      $grid->setSource($source);
      $grid->hideColumns(array('id'));
      $grid->addMassAction(new DeleteMassAction());
      $grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));
      if ($request->isXmlHttpRequest()) return $grid->getGridResponse('DashboardBundle:Contact:indexAjax.html.twig');
      if ($grid->isReadyForRedirect())return new RedirectResponse($grid->getRouteUrl());
      return $grid->getGridResponse('DashboardBundle:Contact:index.html.twig');
    }

    /**
     * @Route("/contacts/new", name="contact_new")
     */
    public function newAction() {
        $renderDir = 'DashboardBundle:Contact:new.html.twig';
        return $this->genericNew($this->nameEntity, $this->nameFormEntity, $renderDir);
    }

    /**
     * @Route("/contacts/create", name="contact_create")
     */
    public function createAction(Request $request) {
        $renderDir = 'DashboardBundle:Contact:new.html.twig';
        $messageSucccess = 'Save contact success';
        $messageError    = 'Exist error in the data form';
        return $this->genericCreate($this->nameEntity, $this->nameFormEntity, $renderDir, $this->nameService, $this->newRouting,$messageSucccess,$messageError);
    }

    /**
     * @Route("/contacts/create_close", name="contact_create_close")
     */
    public function createAndCloseAction(Request $request) {
        $renderDir       = 'DashboardBundle:Contact:new.html.twig';
        $messageSucccess = 'Save contact success';
        $messageError    = 'Exist error in the data form';
        return $this->genericCreate($this->nameEntity, $this->nameFormEntity, $renderDir, $this->nameService, $this->indexRouting,$messageSucccess,$messageError);
    }

    /**
     * @Route("/contacts/delete", name="contact_delete")
     */
    public function deleteAction() {
        $messageInfo = 'Selected one or more contact to delete';
        $messageSucccess = 'Delete contact success';
        $messageError = 'Error in the delete progress';
        return $this->genericDelete($this->nameService, $this->indexRouting,$messageInfo, $messageSucccess,$messageError);
    }


}