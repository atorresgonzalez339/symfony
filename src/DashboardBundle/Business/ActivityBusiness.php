<?php

namespace DashboardBundle\Business;
use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Flyer;
use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class ActivityBusiness extends BaseBusiness {

  public function __construct(EntityManager $em) {
    parent::__construct($em);
  }

  public function getActivityChartData(User $user, $subaccount){
    $userPlan = $user->getCurrentPlan();

    $dateStart = $userPlan->getDateStart();
    $dateEnd = new \DateTime();
    $dateEnd->add(new \DateInterval('P1D'));

    $dateRanges = new \DatePeriod($dateStart, new \DateInterval('P1D'), $dateEnd);

    $result['date_ranges'] = array();
    $result['date_values'] = array();

    foreach($dateRanges as $date){
      $result['date_ranges'][] = $date->format("M d");
      $totalSent = rand(0, $subaccount['custom_quota']);
      $delivered = rand(0, $totalSent);
      $bounced = $totalSent - $delivered;
      $opened = rand(0, $delivered > $bounced ? $delivered : $bounced);
      $result['date_values']['total_sent'][] = $totalSent;
      $result['date_values']['delivered'][] = $delivered > $bounced ? $delivered : $bounced;
      $result['date_values']['bounced'][] = $delivered > $bounced ? $bounced : $delivered;
      $result['date_values']['opened'][] = $opened;
    }

    $result['date_ranges'] = json_encode($result['date_ranges']);
    $result['date_values']['total_sent'] = json_encode($result['date_values']['total_sent']);
    $result['date_values']['delivered'] = json_encode($result['date_values']['delivered']);
    $result['date_values']['bounced'] = json_encode($result['date_values']['bounced']);
    $result['date_values']['opened'] = json_encode($result['date_values']['opened']);

    return $result;

    echo "<pre>";
    print_r($result);
    die('aki');


  }

}