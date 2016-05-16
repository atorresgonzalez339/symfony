<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;
use Doctrine\ORM\EntityManager;
use Hip\MandrillBundle\Message;
use Mandrill;
use UserBundle\Entity\User;

class MandrillBusiness extends BaseBusiness {

    private $mandrillSender;
    private $mandrillApi;

    public function __construct(EntityManager $em, $container) {
      parent::__construct($em);
        $this->mandrillSender = $container->get('hip_mandrill.dispatcher');
        $mandrill_api_key = $container->getParameter('mandrill_api_key');
        $this->mandrillApi = new Mandrill($mandrill_api_key);
    }

    public function createSubAccount(User $user){

      $userCurrentPlan = $user->getProfile()->getCurrentPlan();
      $plan = $userCurrentPlan->getPlan();

      $subaccount_id = $user->getUsername();
      $subaccount_name = $user->getProfile()->getFullName();
      $notes = "{$plan->getName()} plan user, signed up on {$userCurrentPlan->getDateStart()->forma('m/d/Y h:i')}";
      $custom_quota = $plan->getTotalEmails();

      $this->mandrillApi->subaccounts->add($subaccount_id, $subaccount_name, $notes, $custom_quota);

      return $subaccount_id;

    }

    public function updateSubAccount(User $user){

      $userCurrentPlan = $user->getProfile()->getCurrentPlan();
      $plan = $userCurrentPlan->getPlan();
      $subaccount_id = $user->getUsername();
      $notes = "{$plan->getName()} plan user, signed up on {$userCurrentPlan->getDateStart()->forma('m/d/Y h:i')}";
      $custom_quota = $plan->getTotalEmails();

      $this->mandrillApi->update->add($subaccount_id, null, $notes, $custom_quota);

    }

    public function getSubAccount($subaccount_id){
      return $this->mandrillApi->subaccounts->info($subaccount_id);
    }

    public function sendEmail($params){
      $message = new Message();

      $message
        ->setReplyTo($params['sender_email'])
        ->setFromName($params['sender_name'])
        ->setSubject($params['subject'])
        ->setHtml($params['html'])
        ->setSubaccount($params['subaccount']);

      foreach($params['tags'] as $tag){
        $message->addTag($tag);
      }

      foreach($params['metadata'] as $metadata){
        $message->addMetadata($metadata);
      }

      foreach($params['contacts'] as $contactEmail){
        $message->addTo($contactEmail);
      }

      $result = $this->mandrillSender->send($message);

      return $result;
    }



}