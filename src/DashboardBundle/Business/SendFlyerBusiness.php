<?php

namespace DashboardBundle\Business;
use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Flyer;
use Doctrine\ORM\EntityManager;

class SendFlyerBusiness extends BaseBusiness {

    private $mandrillBusiness;

    public function __construct(EntityManager $em, $container) {
      parent::__construct($em);
      $this->mandrillBusiness = $container->get('dashboard.mandrill.business');
    }

    public function sendFlyer(Flyer $flyer, $contacts, $activity_id){

      $params = array(
        'sender_email' => $flyer->getEmail(),
        'sender_name' => $flyer->getSenderName(),
        'subject' => $flyer->getSubject(),
        'html' => $flyer->getHtml(),
        'subaccount' => $flyer->getUser()->getProfile()->getMandrillSubaccount(),
        'tags' => array(
          'flyer',
        ),
        'metadata' => array(
          'activity_id' => $activity_id
        ),
        'contacts' => $contacts
      );

      return $this->mandrillBusiness->sendEmail($params);

    }
}