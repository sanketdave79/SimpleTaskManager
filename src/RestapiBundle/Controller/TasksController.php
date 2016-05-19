<?php

namespace RestapiBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RestapiBundle\Entity\Tasks;
use JMS\SerializerBundle\JMSSerializerBundle;
use FOS\RestBundle\Controller\Annotations\Get;


class TasksController extends Controller
{
 
    /**
     * @Rest\View
     */
    
    public function allAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();
        $serializer = $this->container->get('jms_serializer');
        $response = $serializer->serialize($tasks, 'json');
        return new Response($response); 
    }
    
    /**
     * @Rest\View
     */
    
    public function gettasksAction($id)
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();
        $usertasks = [];
        foreach($tasks as $task)
        {
            $userid = $task->getUser()->getId();
            if($id == $userid)
            {
                array_push($usertasks, $task);
            }
        }
        $serializer = $this->container->get('jms_serializer');
        $response = $serializer->serialize($usertasks, 'json');
        return new Response($response); 
        
    }
   
    /**
     * @Rest\View
     */
    
    public function gettaskAction($id)
    {
       $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);
       $serializer = $this->container->get('jms_serializer');
        $reports = $serializer->serialize($task, 'json');
        return new Response($reports); 
    }

    
}
