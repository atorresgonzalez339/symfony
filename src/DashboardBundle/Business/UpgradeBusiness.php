<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Plan;
use DashboardBundle\Entity\UserPlan;
use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class UpgradeBusiness extends BaseBusiness
{

  private $container;

  public function __construct(EntityManager $em, $container)
  {
    parent::__construct($em);
    $this->container = $container;
    $stripeParams = $container->getParameter('stripe_params');
    $apiKey = $stripeParams['secret_key'];
    \Stripe::setApiKey($apiKey);
  }

  public function updatePlan(User $user, Plan $plan, $coupon_id = null)
  {

    $customer_id = $user->getProfile() ? $user->getProfile()->getCustomerId() : null;
    $new_plan_id = $plan->getId();

    if ($customer_id) {

      $customer = \Stripe_Customer::retrieve($customer_id);

      if ($coupon_id && $this->getCuponById($coupon_id)) {
        $customer->coupon = $coupon_id;
        $customer->save();
      }

      if ($new_plan_id !== 1) {

        $currentSubscription = $this->getCurrentSubscription($user, $customer);

        $subscription = $customer->subscriptions->retrieve($currentSubscription['id']);
        $subscription->plan = $new_plan_id;
        $proration_date = new \DateTime();
        $subscription->proration_date = $proration_date->getTimestamp();
        $subscription->tax_percent = 7;
        $subscription->save();

        $current_plan_id = $user->getCurrentPlan()->getPlan()->getId();

        if ($current_plan_id != 1) {

          $invoice = \Stripe_Invoice::create(array(
            "customer" => $customer_id,
            "subscription" => $subscription['id']
          ));

          $result = $invoice->pay();

          if ($result->paid != true) {
            $invoice->closed = true;
            $invoice->save();
            $customer->updateSubscription(array(
              'plan' => $current_plan_id,
              'prorate' => false,
              'application_fee_percent' => 4,
              'tax_percent' => 7
            ));
          }
        }
      }
    } else {

      //Inscribir al Usuario en el Plan Free por primera vez
      $customer = \Stripe_Customer::create(array(
        "plan" => $new_plan_id,
        "email" => $user->getEmail()
      ));

      $customer_id = $customer->id;
    }

    //Update Current Plan
    if (is_array($customer->subscriptions->data)) {
      foreach ($customer->subscriptions->data as $data) {
        if ($data->status == 'active') {
          $dateStart = $data->current_period_start;
          $dateEnd = $data->current_period_end;
          break;
        }
      }
    } else {
      $dateStart = $customer->subscriptions->data->current_period_start;
      $dateEnd = $customer->subscriptions->data->current_period_end;
    }

    $dateTimeStart = new \DateTime();
    $dateTimeStart->setTimestamp($dateStart);

    $dateTimeEnd = new \DateTime();
    $dateTimeEnd->setTimestamp($dateEnd);

    $userPlan = new UserPlan($user, $plan);
    $userPlan->setDateStart($dateTimeStart);
    $userPlan->setDateEnd($dateTimeEnd);

    $user->getProfile()->setCustomerId($customer_id);
    $user->addPlan($userPlan);

    $this->saveData($user);

    return $plan;
  }

  public function addNextPlan(UserPlan $currentPlan, Plan $nextPlan = null) {

    $customer_id = $currentPlan->getUser()->getProfile()->getCustomerId();

    $customer = \Stripe_Customer::retrieve($customer_id);

    $this->getEM()->beginTransaction();

    try {

      if($nextPlan){
        $currentPlan->setNextPlan($nextPlan);
      }
      else{
        $currentPlan->setNextPlan(null);
      }

      $this->saveData($currentPlan);
      $this->getEM()->commit();

      $customer->updateSubscription(array(
        'plan' => $nextPlan ? $nextPlan->getId() : $currentPlan->getPlan()->getId(),
        'prorate' => false
      ));

      $customer->save();


    } catch (\Exception $e) {
      $this->getEM()->rollback();
      throw $e;
    }
  }

  public function renewPlan($stripe_event) {
    $customer_id = $eventStripe->data->object->customer;

    $userProfile = $this->getRepository('User', 'UserProfile')
      ->findOneBy(array('customer_id' => $customer_id));

    $user = $userProfile->getUser();

    $currentPlan = $user->getCurrentPlan();

    $dateStart = $currentPlam->getDateStart();

    if($dateStart->getTimestamp() !== $eventStripe->data->object->lines->data[0]->period->start)
    {
      $idplan = $eventStripe->data->object->lines->data[0]->plan->id;
      $idplan = $idplan ? $idplan : 1;
      $this->updatePlan($member, $idplan);
    }
  }

  public function cancelSubscription(){
    $customerId = $eventStripe->customer;

    $member = $this->getRepository('Contakta', 'Member')
      ->findOneBy(array('customerid' => $customerId));

    if($member){
      $this->updatePlan($member, 1);
    }
  }

  public function updateCard(User $user, $token)
  {

    $customer_id = $user->getProfile()->getCustomerId();

    $customer = \Stripe_Customer::retrieve($customer_id);

    $cards = $customer->sources->all(array("object" => "card"));

    if ($cards && $cards->data) {
      foreach ($cards->data as $card) {
        $customer->sources->retrieve($card['id'])->delete();
      }
    }

    return $customer->sources->create(array("source" => $token))->__toArray(true);;
  }

  public function getCardInformation(User $user)
  {
    $customer_id = $user->getProfile() ? $user->getProfile()->getCustomerId() : null;

    if ($customer_id) {

      $customer = \Stripe_Customer::retrieve($customer_id);

      $cards = $customer->sources->all(array("object" => "card"));

      if ($cards && $cards->data) {
        return $cards->data[0]->__toArray();
      }
    }

    return null;
  }

  public function getInvoices(User $user)
  {
    $customer_id = $user->getProfile() ? $user->getProfile()->getCustomerId() : null;

    if ($customer_id) {
      $invoices = \Stripe_Invoice::all(array("customer" => $customer_id));

      if ($invoices && $invoices->data) {
        return $invoices->data;
      }
    }

    return null;
  }

  public function getCouponById($coupon_id)
  {

    $coupon = \Stripe_Coupon::retrieve($coupon_id);

    if ($coupon->valid) {
      return $coupon;
    } else {
      throw new \Stripe_Error('Coupon is expired or invalid.');
    }

  }

  private function getCurrentSubscription(User $user, $customer)
  {

    $currentPlan = $user->getCurrentPlan();
    $plan = $currentPlan->getPlan();

    $subscriptions = $customer->subscriptions->all();

    foreach ($subscriptions->data as $subscription) {
      if ($subscription['plan']['id'] == $plan->getId()) {
        return $subscription;
      }
    }

    return null;

  }

  public function getTotalAmount(Plan $plan){
    $tax = $plan->getPrice() * 0.07;
    return $plan->getPrice() + $tax;
  }


}