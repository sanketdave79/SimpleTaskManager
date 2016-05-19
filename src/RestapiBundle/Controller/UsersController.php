<?php

namespace RestapiBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use RestapiBundle\Entity\Users;
use FOS\RestBundle\Routing\ClassResourceInterface;



class UsersController extends Controller
{
    /**
     * @Rest\View
     */
 
    public function allAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $serializer = $this->container->get('jms_serializer');
        $response = $serializer->serialize($users, 'json');
        return new Response($response);
        
    }
    
    /**
     * @Rest\View
     */
    
    public function getuserinfoAction($id)
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $serializer = $this->container->get('jms_serializer');
        $response = $serializer->serialize($users, 'json');
        return new Response($response);
        
    }

    
}