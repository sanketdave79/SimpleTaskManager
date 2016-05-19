<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Task;
use Symfony\Component\Validator\Constraints\DateTime;


class TaskController extends Controller
{
    /**
     * @Route("/app/tasks/", name="tasks")
     */
    
    public function indexAction()
    {
         $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        // find *all* products
            $tasks = $repository->findAll();
            $tasks = array('tasks' => $tasks);
              if (!$tasks) {
        throw $this->createNotFoundException(
            'No tasks found'
        );    
         }
            if($tasks){
         return $this->render('tasks/index.html.twig',$tasks);
            }
    }
    
    /**
     *@Route("/app/tasks/listtasks",name="listtasks")
     */
    public function listtasksAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        // find *all* products
            $tasks = $repository->findAll();
            $tasks = array('tasks' => $tasks);
              if (!$tasks) {
        throw $this->createNotFoundException(
            'No tasks found'
        );    
         }
            if($tasks){
         return $this->render('tasks/index.html.twig',$tasks);
            }
          
    }
    
    /**
     *@Route("/app/tasks/addtask",name="addtask")
     */
    
    public function addtaskAction(Request $request)
    {
        
        
        $usersRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $usersRepository->findAll();
        $userChoices = array();
foreach ($users as $user) {
    $key = $user->getId();
    $value = $user->getName();
    $userChoices[$key] = $value;
}
        
        $task = new Task();
       

        $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description','text')
                ->add('date','integer')
                ->add('duedate', 'date', ['widget' => 'choice', 'format' => 'yyyy-MM-dd'])
                ->add('user','choice',array('mapped'=>false,'choices' => $userChoices,'required' => TRUE))
            ->add('save', 'submit', array('label' => 'Create Task'))
            ->getForm();
        
        $form->handleRequest($request);
if ($request->isMethod('POST')) {
    if ($form->isValid()) {
        
        $data = $request->request->all();
$title = $data['form']['title'];
$date = $data['form']['date'];
$description = $data['form']['description'];
$duedate = $data['form']['duedate'];
$userid = $data['form']['user'];

$duedateformated = $duedate['year']."-".$duedate['month']."-".$duedate['day'];

        // perform some action, such as saving the task to the database
        $task->setTitle($title);
        $task->setDate($date);
        $task->setDescription($description);
        $task->setDuedate(new \DateTime($duedateformated));
                $userslist = $this->getDoctrine()->getRepository('AppBundle:User');
        $selecteduser = $userslist->findOneBy(array('id'=>$userid));
        $task->setUser($selecteduser);
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute('listtasks');
    }
}

        return $this->render('tasks/defaultaddtaskform.html.twig', array(
            'form' => $form->createView(),));
    }
    
     /**
     *@Route("/app/task/{id}/edit",name="edittask")
     */
    
    public function edittaskAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        // find *all* products
            $task = $repository->findOneBy(array('id'=>$id));
            
              if (!$task) {
        throw $this->createNotFoundException(
            'No task found'
        );    
         }
         
          $usersRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $usersRepository->findAll();
        $userChoices = array();
foreach ($users as $user) {
    $key = $user->getId();
    $value = $user->getName();
    $userChoices[$key] = $value;
}

         $userid = $task->getUser()->getId();
         $duedate = $task->getDuedate();
         
          $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description','text')
                ->add('date','integer')
                  ->add('duedate', 'date', ['widget' => 'choice', 'format' => 'yyyy-MM-dd','data' => $duedate])
                 // ->add('date', 'date', ['widget' => 'choice', 'format' => 'dd-MM-yyyy'])
                ->add('user','choice',array('mapped'=>false,'choices' => $userChoices,'required' => TRUE, 'data' => $userid))
            ->add('save', 'submit', array('label' => 'Edit Task'))
            ->getForm();
        
        $form->handleRequest($request);
if ($request->isMethod('POST')) {
    if ($form->isValid()) {
        
        $data = $request->request->all();
$duedate = $data['form']['duedate'];
$title = $data['form']['title'];
$date = $data['form']['date'];
$description = $data['form']['description'];
$userid = $data['form']['user'];

        $duedateformated = $duedate['year']."-".$duedate['month']."-".$duedate['day'];
        // perform some action, such as saving the task to the database
        $task->setTitle($title);
        $task->setDate($date);
        $task->setDescription($description);
        $task->setDuedate(new \DateTime($duedateformated));
        $userslist = $this->getDoctrine()->getRepository('AppBundle:User');
        $selecteduser = $userslist->findOneBy(array('id'=>$userid));
        $task->setUser($selecteduser);
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute('listtasks');
    }
}

        return $this->render('tasks/defaultaddtaskform.html.twig', array(
            'form' => $form->createView(),));
        
    }
}

