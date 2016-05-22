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
          case "send":
          case "hard_bounce":
          case "soft_bounce":
          case "open":
          case "spam":
          case "spamreport":
          case "deferral":
          case "reject":
          case "unsub":
            $this->standardEventsHandler($event);
            break;
          case "click": {
            $this->event_click($event);
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

  function standardEventsHandler($event)
  {
    $activityBusiness = $this->findBusiness('dashboard.activity.business');

    $email = $event['msg']['email'];
    $metadata = $event['msg']['metadata'];
    $tags = $event['msg']['tags'];

    $state = $event['msg']['state'];
    $date_sent = $event['msg']['ts'];
    $message_id = $event['msg']['_id'];

    $bounced_reason = null;
    $bounced_description = null;

    switch($event["event"]){
      case 'soft_bounce':
      case 'hard_bounce':
      case 'deferral':
      case 'reject': {
        $bounced_description = $event['msg']['diag'];
        $bounced_reason = $event['msg']['bounce_description'];
      break;
      }
    }

    if(in_array('flyer', $tags) && in_array('activity_id', $metadata)){
      $activity_id = $metadata['activity_id'];
      $activityBusiness->processFlyerEvent($email, $activity_id, $event);
    }
  }

  function event_click($event)
  {

  } // function event_click($event)

  function webhooks_debug($event)
  {

  }
}