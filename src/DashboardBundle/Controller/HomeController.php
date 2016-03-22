<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function indexAction(Request $request){
			return $this->render('DashboardBundle:Dashboard:index.html.twig');
    }
}