<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class HandlerController extends BaseController
{

  /**
   * @Route("/stripe", name="stripe_handler")
   */
  public function StripeHandlerAction(Request $request)
  {

    $upgradeBusiness = $this->findBusiness('dashboard.upgrade.business');

    $event = json_decode($request->getContent(), true);

    $stripeEvent = \Stripe_Event::retrieve($event['id']);

    if ($stripeEvent && isset($stripeEvent->type)) {
      switch ($stripeEvent->type) {
        case 'invoice.payment_succeeded':
          $upgradeBusiness->renewPlan($stripeEvent);
          break;
      }
    }

    return new Response('Successfully');
  }

  /**
   * @Route("/mandrill", name="mandrill_handler")
   */
  public function MandrillHandlerAction(Request $request)
  {

    $HTTP_RAW_POST_DATA = @file_get_contents('php://input');
    $dec_url = urldecode($HTTP_RAW_POST_DATA);
    $json_payload = substr($dec_url, 16);
    $events = json_decode($json_payload, true);

    foreach ($events as $event) {
      if (filter_var($event['msg']['email'], FILTER_VALIDATE_EMAIL)) {
        switch ($event["event"]) {
          case "send": {
            $this->event_send($event);
            break;
          }
          case "deferral": {
            $this->webhooks_soft_bounce($event);
            break;
          }
          case "hard_bounce": {
            $this->webhooks_hard_bounce($event);
            break;
          }
          case "soft_bounce": {
            $this->webhooks_soft_bounce($event);
            break;
          }
          case "open": {
            $this->event_open($event);
            break;
          }
          case "click": {
            $this->event_click($event);
            break;
          }
          case "spam": {
            $this->webhooks_spam_report($event);
            break;
          }
          case "spamreport": {
            $this->webhooks_spam_report($event);
            break;
          }
          case "unsub": {
            $this->event_unsubscribe($event);
            break;
          }
          case "reject": {
            $this->webhooks_hard_bounce($event['msg']['email'], "reject: " . $event['msg']['bounce_description']);
            break;
          }
          default: {
            $this->webhooks_debug(" == Invalid category: '" . $event["category"] . "' for: " . $event["recipient"] . " ==");
          }
        }
      } else { // invalid email address
        $this->webhooks_debug(" == Invalid email address: '" . $event['msg']['email'] . "' ==");
      } // if (filter_var($event["recipient"],FILTER_VALIDATE_EMAIL))
    }

  }

  function event_send($event)
  {
    $email = $event['msg']['email'];
    $metadata = $event['msg']['metadata'];
    $tags = $event['msg']['tags'];
  }

  function webhooks_soft_bounce($event){

  }

  function webhooks_hard_bounce($event){

  }

  function webhooks_spam_report($event){

  }

  function event_open($event)
  {

  } // function event_open($event)

  function event_click($event)
  {

  } // function event_click($event)

  function event_unsubscribe($event)
  {

  } // function event_unsubscribe($event)

  function webhooks_debug($event)
  {

  }
}