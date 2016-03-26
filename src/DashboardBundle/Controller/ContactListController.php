<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class ContactListController extends BaseController{

    private $nameEntity     = '\DashboardBundle\Entity\ContactList';
    private $nameFormEntity = '\DashboardBundle\Form\ContactListType';
    private $nameService    = 'dashboard.contactlist.business';
    private $indexRouting   = 'contactlist_index';
    private $newRouting     = 'contactlist_new';

    public function getBusiness() {
        return parent::findBusiness($this->nameService);
    }

  /**
   * @Route("/contactslist", name="contactlist_index")
   */
    public function indexAction(Request $request){
      $source = new Entity('DashboardBundle:ContactList');
      $grid = $this->get('grid');
      $grid->setSource($source);
      $grid->hideColumns(array('id'));
      $grid->addMassAction(new DeleteMassAction());
      $grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));
      if ($request->isXmlHttpRequest()) return $grid->getGridResponse('DashboardBundle:ContactList:indexAjax.html.twig');
      if ($grid->isReadyForRedirect())return new RedirectResponse($grid->getRouteUrl());
      return $grid->getGridResponse('DashboardBundle:ContactList:index.html.twig');
    }

    /**
     * @Route("/contactslist/new", name="contactlist_new")
     */
    public function newAction() {
        $renderDir = 'DashboardBundle:ContactList:new.html.twig';
        return $this->genericNew($this->nameEntity, $this->nameFormEntity, $renderDir);
    }

    /**
     * @Route("/contactslist/create", name="contactlist_create")
     */
    public function createAction(Request $request) {
        $renderDir = 'DashboardBundle:ContactList:new.html.twig';
        $messageSucccess = 'Save contact List success';
        $messageError    = 'Exist error in the data form';
        return $this->genericCreate($this->nameEntity, $this->nameFormEntity, $renderDir, $this->nameService, $this->newRouting,$messageSucccess,$messageError);
    }

    /**
     * @Route("/contactslist/create_close", name="contactlist_create_close")
     */
    public function createAndCloseAction(Request $request) {
        $renderDir       = 'DashboardBundle:ContactList:new.html.twig';
        $messageSucccess = 'Save contact list success';
        $messageError    = 'Exist error in the data form';
        return $this->genericCreate($this->nameEntity, $this->nameFormEntity, $renderDir, $this->nameService, $this->indexRouting,$messageSucccess,$messageError);
    }

    /**
     * @Route("/contactslist/delete", name="contactlist_delete")
     */
    public function deleteAction() {
        $messageInfo = 'Selected one or more contact list to delete';
        $messageSucccess = 'Delete contact list success';
        $messageError = 'Error in the delete progress';
        return $this->genericDelete($this->nameService, $this->indexRouting,$messageInfo, $messageSucccess,$messageError);
    }

    /**
     * @Route("/contactslist/edit", name="contactlist_edit")
     */
    public function editAction(){
        $renderDir       = 'DashboardBundle:ContactList:edit.html.twig';
        $messageInfoNotSelected = 'Selected one or more contact list to delete';
        $messageInfo = 'Not has selected entity contact list success';
        return $this->genericEdit($this->nameFormEntity, $renderDir, $this->nameService, $this->indexRouting,$messageInfoNotSelected,$messageInfo);
    }

    /**
     * @Route("/contactslist/update/{id}", name="contactlist_update")
     */
    public function updateAction($id) {
        $renderDir       = 'DashboardBundle:Con tact:edit.html.twig';
        $messageInfoNotSelected = 'Selected one or more contact list to delete';
        $messageSucccess = 'Update contact list success';
        $messageError    = 'Exist error in the data form';
        return $this->genericUpdate($id, $this->nameFormEntity, $renderDir, $this->nameService, $this->indexRouting,$messageInfoNotSelected,$messageSucccess,$messageError);
    }

    public function genericCreate($nameEntity, $nameFormEntity, $renderDir, $nameService, $routing, $messageSucccess = '', $messageError = '', $nameFormView = 'form') {
        $request = $this->getRequest();
        $entity = new $nameEntity();
        $form = $this->createForm(new $nameFormEntity(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $entity->setUser($this->getUserAuthenticated());
            $this->findBusiness($nameService)->saveData($entity);
            $this->addFlash('success', $messageSucccess, $routing);
            return $this->redirect($this->generateUrl($routing));
        } else {
            $this->addFlash('info', $messageError);
            return $this->render($renderDir, array('entity' => $entity,$nameFormView => $form->createView()));
        }
    }

}