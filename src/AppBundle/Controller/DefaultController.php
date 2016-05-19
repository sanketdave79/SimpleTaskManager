<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/app/dashboard", name="dashboard")
     */
    public function indexAction()
    {
        $message = 'Central Control Panel';
        $fbdata = $this->forward('Appbundle:Socialmediaposts:addfbpagepost');
        $data = array('fbdata'=>$fbdata,'message'=>$message);
        return $this->render('default/index.html.twig',$data);
    }
}
