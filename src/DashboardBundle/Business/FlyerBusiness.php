<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Flyer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class FlyerBusiness extends BaseBusiness
{

  private $utilsBusiness;

  public function __construct(EntityManager $em, $container)
  {
    parent::__construct($em);
    $this->utilsBusiness = $container->get('dashboard.utils.business');
  }

  public function saveFlyer(Flyer $flyer)
  {
    $this->saveData($flyer);
  }

  public function replaceImages(Flyer $flyer)
  {
    $flyer_html = $flyer->getHtml();

    $crawler = new Crawler();
    $crawler->addHtmlContent($flyer_html);
    foreach ($crawler->filter('img') as $domElement) {
      $attr_src = $domElement->getAttribute('src');
      if (!$this->validateURL($attr_src)) {
        $result = $this->utilsBusiness->upladImage($attr_src, 'flyers');
        $domElement->setAttribute('src', $result['url']);
      }
    }

    $flyer->setHtml($crawler->html());
    $this->saveData($flyer);

    return $flyer;
  }

  function validateURL($text)
  {
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    if (preg_match($reg_exUrl, $text, $result)) {
      return true;
    } else {
      return false;
    }
  }
}