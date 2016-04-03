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
      $grid->hideColumns(array('id','is_unsubscribed'));
      $grid->addMassAction(new DeleteMassAction());
      $grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));
      $tableAlias = $source->getTableAlias();
      $source->manipulateQuery(
        function ($query) use ($tableAlias) {
            $query->addOrderBy($tableAlias.'.id', 'DESC');
        }
      );
      $grid->setSource($source);


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

    /**
     * @Route("/contacts/edit", name="contact_edit")
     */
    public function editAction(){
        $renderDir       = 'DashboardBundle:Contact:edit.html.twig';
        $messageInfoNotSelected = 'Selected one or more contact to delete';
        $messageInfo = 'Not has selected entity contact success';
        return $this->genericEdit($this->nameFormEntity, $renderDir, $this->nameService, $this->indexRouting,$messageInfoNotSelected,$messageInfo);
    }

    /**
     * @Route("/contacts/update/{id}", name="contact_update")
     */
    public function updateAction($id) {
        $renderDir       = 'DashboardBundle:Con tact:edit.html.twig';
        $messageInfoNotSelected = 'Selected one or more contact to delete';
        $messageSucccess = 'Update contact success';
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