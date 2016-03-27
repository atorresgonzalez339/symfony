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

    $customer_id = $user->getProfile()->getCustomerId();
    $new_plan_id = $plan->getId();

    if ($customer_id) {

      $customer = \Stripe_Customer::retrieve($customer_id);

      if ($coupon_id && $this->getCuponById($coupon_id)) {
        $customer->coupon = $coupon_id;
        $customer->save();
      }

      if ($new_plan_id !== 1) {

        $plan_amount = $plan->getPrice();

        $invoiceItem = \Stripe_InvoiceItem::create(
          array(
            "customer" => $customer_id,
            "amount" => $plan_amount * 100,
            "currency" => "usd"
          )
        );

        $invoice = \Stripe_Invoice::create(array(
          "customer" => $customer_id,
        ));

        $result = $invoice->pay();

        if ($result->paid == true) {
          $customer->updateSubscription(array(
            'plan' => $new_plan_id,
            'prorate' => false
          ));
        } else {
          $invoice->closed = true;
          $invoice->save();
        }
      } else {

        $customer->updateSubscription(array(
          'plan' => $new_plan_id,
          'prorate' => false
        ));

        $customer->save();

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

  public function updateCard(User $user, $token){

    $customer_id = $user->getProfile()->getCustomerId();

    $customer = \Stripe_Customer::retrieve($customer_id);

    $cards = $customer->sources->all(array("object" => "card"));

    if ($cards) {
      foreach ($cards->data as $card) {
        $customer->sources->retrieve($card['id'])->delete();
      }
    }

    return $customer->sources->create(array("source" => $token))->__toArray(true);;
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


}