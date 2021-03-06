<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use DashboardBundle\Entity\Contact;
use DashboardBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use Symfony\Component\HttpFoundation\Response;

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
      $grid->hideColumns(array('id'));
      $grid->addMassAction(new DeleteMassAction());
      $grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));
      $tableAlias = $source->getTableAlias();

       $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                $idUser = $this->getUserAuthenticated()->getId();
                $query->leftJoin($tableAlias.'.user', 'u')
                    ->andWhere('u.id = '. $idUser)
                    ->addOrderBy($tableAlias.'.id', 'DESC');
            }
        );
        $grid->setSource($source);

        if ($request->isXmlHttpRequest()){
          return $grid->getGridResponse('DashboardBundle:ContactList:indexAjax.html.twig');
      }
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
     * @Method({"GET","POST"})
     */
    public function editAction(){
        $renderDir       = 'DashboardBundle:ContactList:edit.html.twig';
        $messageInfoNotSelected = 'Selected one or more contact list to delete';
        $messageInfo = 'Not has selected entity contact list success';

        return $this->genericEdit($this->nameFormEntity, $renderDir, $this->nameService, $this->indexRouting,$messageInfoNotSelected,$messageInfo);
    }

    private function isRedirectFromGrid($queryString){
        $queryStringArray = explode('&',$queryString);
        if(count($queryString)==0) return false;
        $redirectGridParam = $queryStringArray[count($queryStringArray)-1];
        $redirectGridParamArray = explode('=',$redirectGridParam);
        $redirectGridParamFirst = $redirectGridParamArray[0];
        if($redirectGridParamFirst == 'REDIRECT_GRID') return true;
        return false;
    }

    private function isRedirectFromFirstGrid($queryString){
        $queryStringArray = explode('&',$queryString);
        if(count($queryString)==0) return false;
        $redirectGridParam = $queryStringArray[count($queryStringArray)-1];
        $redirectGridParamArray = explode('=',$redirectGridParam);
        $redirectGridParamFirst = $redirectGridParamArray[1];
        if($redirectGridParamFirst == 'FIRST') return true;
        return false;
    }

    private function getIdContactListIsRedirectFromGrid($queryString){
        $queryStringArray = explode('&',$queryString);
        if(count($queryString)==0) return false;
        $redirectGridParam = $queryStringArray[count($queryStringArray)-2];
        $redirectGridParamArray = explode('=',$redirectGridParam);
        $redirectGridParamSecond = $redirectGridParamArray[1];
        return $redirectGridParamSecond;
    }

    public function genericEdit($nameFormEntity, $renderDir, $nameService, $indexRouting,$messageInfoNotSelected ='',$messageInfo ='', $nameFormView = 'form') {
        $queryString = $_SERVER['QUERY_STRING'];
        $idSelected = $this->getFiertSelectetGridItem();
        $isRedirectGrid = $this->isRedirectFromGrid($queryString);
        if($isRedirectGrid) $idSelected = $this->getIdContactListIsRedirectFromGrid($queryString);

        if (!$idSelected && !$isRedirectGrid) {
            $this->addFlash('info', $messageInfoNotSelected);
            return $this->redirect($this->generateUrl($indexRouting));
        }else{
            $this->setSession('SELECTED_EDIT_CONTACTLIST_ID',$idSelected);
        }
        $entity = $this->findBusiness($nameService)->findByID($idSelected);
        if (!$entity) {
            return $this->addFlash('info', $messageInfo, $indexRouting);
        }
        $editForm = $this->createForm(new $nameFormEntity(), $entity);
        $formContact = $this->createForm(new ContactType(), new Contact());

        $source = new Entity('DashboardBundle:Contact');
        $gridManager = $this->get('grid.manager');
        $grid = $gridManager->createGrid('FIRST');
        $grid->hideColumns(array('id'));
        $grid->addMassAction(new DeleteMassAction());
        $grid->setLimits(array(10));
        $idContacts = $this->findBusiness('dashboard.contact.business')->getIdContactByIdContactList($idSelected);

        $idUser = $this->getUserAuthenticated()->getId();

        if($idContacts){
            $tableAlias = $source->getTableAlias();
            $source->manipulateQuery(
              function ($query) use ($tableAlias,$idContacts,$idUser) {
                  $query->leftJoin($tableAlias.'.user', 'u')
                        ->andWhere($tableAlias.'.id NOT IN(:ids)')
                        ->andWhere('u.id = '.$idUser)
                        ->addOrderBy($tableAlias.'.id', 'DESC')
                        ->setParameter(':ids', $idContacts);
              }
            );
        }
        $grid->setSource($source);

        $source2 = new Entity('DashboardBundle:Contact');
        $grid2 = $gridManager->createGrid('SECOND');
        $grid2->hideColumns(array('id'));
        $grid2->addMassAction(new DeleteMassAction());
        $grid2->setLimits(array(10));
        $tableAlias2 = $source2->getTableAlias();
        $source2->manipulateQuery(
            function ($query) use ($tableAlias2,$idSelected,$idUser) {
                $query->leftJoin($tableAlias2.'.contactList', 'cl')
                      ->leftJoin($tableAlias2.'.user', 'u')
                      ->andWhere('cl.id = '.$idSelected )
                      ->andWhere('u.id = '.$idUser)
                      ->addOrderBy($tableAlias2.'.id', 'DESC');
            }
        );
        $grid2->setSource($source2);

        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()){
            if($this->isRedirectFromFirstGrid($queryString))
                return $grid->getGridResponse('DashboardBundle:ContactList:contactAjax.html.twig');
            else
                return $grid2->getGridResponse('DashboardBundle:ContactList:myContactAjax.html.twig');
        }

        if ($gridManager->isReadyForRedirect()) {
            return new RedirectResponse($gridManager->getRouteUrl());
        }
        else
        {
            return $this->render($renderDir, array(
                'entity' => $entity,
                $nameFormView => $editForm->createView(),
                'form_contact' => $formContact->createView(),
                'grid' => $grid,
                'grid2' => $grid2,
            ));
        }
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

    /**
     * @Route("/contactslist/switch2contactlist", name="contactlist_switch2contactlist")
     */
    public function switch2contactlistAction() {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        $request = $this->getRequest();
        $idContactList = $request->get('idContactList');
        $idContact     = $request->get('idContact');
        if (!$idContact && !$idContactList) {
            $messageInfoNotSelected = 'Selected one contact list to assign the current contact list';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfoNotSelected)));
            return $response;
        }
        $entityContact = $this->findBusiness('dashboard.contact.business')->findByID($idContact);
        if(!$entityContact){
            $messageInfo = 'Not has selected entity contact success';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }
        $entityContactList = $this->getBusiness()->findByID($idContactList);
        if(!$entityContactList){
            $messageInfo = 'Not has selected entity contact list success';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }
        $messageInfo = 'New contact added to this list';
        $result = $this->getBusiness()->addContact($entityContactList,$entityContact);
        if($result == false) $messageInfo = 'Error moving the contact';
        $response->setStatusCode(200);
        $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>200)));
        return $response;
    }
    /**
     * @Route("/contactslist/remove2contactlist", name="contactlist_remove2contactlist")
     */
    public function remove2contactlistAction() {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        $request = $this->getRequest();
        $idContactList = $request->get('idContactList');
        $idContact     = $request->get('idContact');
        if (!$idContact && !$idContactList) {
            $messageInfoNotSelected = 'Selected one or more contact list to assign the current contact list';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfoNotSelected)));
            return $response;
        }
        $entityContact = $this->findBusiness('dashboard.contact.business')->findByID($idContact);
        if(!$entityContact){
            $messageInfo = 'Not has selected entity contact success';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }
        $entityContactList = $this->getBusiness()->findByID($idContactList);
        if(!$entityContactList){
            $messageInfo = 'Not has selected entity contact list success';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }
        $messageInfo = 'A contact removed from this list';
        $result = $this->getBusiness()->removeContact($entityContactList,$entityContact);
        if($result == false) $messageInfo = 'Error removing the contact';
        $response->setStatusCode(200);
        $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>200)));
        return $response;
    }
    /**
     * @Route("/contactslist/addcontact2contactlist", name="contactlist_addcontact2contactlist")
     */
    public function addcontact2contactlistAction() {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        $request = $this->getRequest();
        $idContactList = $this->getSession('SELECTED_EDIT_CONTACTLIST_ID');
        if (!$idContactList) {
            $messageInfoNotSelected = 'Selected one contact list to assign the current contact list';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfoNotSelected)));
            return $response;
        }
        $entityContactList = $this->getBusiness()->findByID($idContactList);
        if(!$entityContactList){
            $messageInfo = 'Not has selected entity contact list success';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }

        $entityContact = new Contact();
        $formContact   = $this->createForm(new ContactType(), $entityContact);
        $formContact->bind($request);

        if ($formContact->isValid()) {
            $entityContact->setUser($this->getUserAuthenticated());
            $this->findBusiness($this->nameService)->saveData($entityContact);
            $result = $this->getBusiness()->addContact($entityContactList,$entityContact);
            $messageInfo = 'New contact added to this list';
            if($result == false) $messageInfo = 'Error adding a new contact';
            $response->setStatusCode(200);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>200)));
            return $response;
        }else{
            $messageInfo = 'Exist error in the data contact';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }
    }

    /**
     * @Route("/contactslist/bulk_addcontact2contactlist", name="bulk_addcontact2contactlist")
     */
    public function bulk_addcontact2contactlistAction(){
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        $request        = $this->getRequest();
        $requestArray   = $request->get('requestArray');
        $idContactList  = $this->getSession('SELECTED_EDIT_CONTACTLIST_ID');
        if (!$idContactList) {
            $messageInfoNotSelected = 'Selected one contact list to assign the current contact list';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfoNotSelected)));
            return $response;
        }
        $entityContactList = $this->getBusiness()->findByID($idContactList);
        if(!$entityContactList){
            $messageInfo = 'Not has selected entity contact list success';
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>401)));
            return $response;
        }
        $dataArray = $requestArray['data'];
        $resultArray  = array();
        foreach ($dataArray as $contact) {
            $firstName  = $contact['firstName'];
            $middleName = isset($contact['middleName']) ? $contact['middleName'] : '';
            $lastName   = $contact['lastName'];
            $email      = $contact['email'];
            $entityContact = new Contact();
            $names = $firstName;
            if(strlen($middleName)>0) $names.= ' '.$middleName;
            $entityContact->setFirstName($names);
            $entityContact->setLastName($lastName);
            $entityContact->setUser($this->getUserAuthenticated());
            $entityContact->setEmail($email);
            $this->findBusiness($this->nameService)->saveData($entityContact);
            $resultArray[] = $this->getBusiness()->addContact($entityContactList,$entityContact);
        }
        $messageInfo = 'Import contacts successfully';
        $response->setStatusCode(200);
        $response->setContent(json_encode(array('message'=>$messageInfo,'code'=>200)));
        return $response;
    }

}