<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile_index")
     */
    public function newAction(Request $request){
        return $this->render('DashboardBundle:Profile:index.html.twig');
    }
}
