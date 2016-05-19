<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;

class UserController extends Controller
{
    /**
     * @Route("/app/users/list", name="users")
     */
    
    public function indexAction()
    {
        
       $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        // find *all* products
            $users = $repository->findAll();
            
           // $users = array('users' => $users);
              if (!$users) {
        throw $this->createNotFoundException(
            'No event found'
        );    
         }
            if($users){
        // return $this->render('users/index.html.twig',$users);
                return $users;
            }
    }
    
     public function userobjectsAction()
    {
        
       $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        // find *all* products
            $users = $repository->findAll();
            
            
              if (!$users) {
        throw $this->createNotFoundException(
            'No event found'
        );    
         }
            if($users){
         return $users;
            }
    }
    
    /**
     * @Route("/app/users/listusers", name="listusers")
     */
    
    public function listusersAction()
    {
        
         $repository = $this->getDoctrine()->getRepository('AppBundle:User');
            $users = $repository->findAll();
            
            $users = array('users' => $users);
              if (!$users) {
        throw $this->createNotFoundException(
            'No event found'
        );    
         }
            if($users){
         return $this->render('users/index.html.twig',$users);
            }
    }
    
    /**
     * @Route("/app/users/adduser", name="adduser")
     */
    
    public function adduserAction(Request $request)
    {
        
        $user = new User();
       

        $form = $this->createFormBuilder($user)
            ->add('name', 'text')
            ->add('username', 'text')
            ->add('email','text')
                ->add('password','password')
            ->add('save', 'submit', array('label' => 'Create User'))
            ->getForm();
        
        $form->handleRequest($request);
if ($request->isMethod('POST')) {
    if ($form->isValid()) {
        
        $data = $request->request->all();
$name = $data['form']['name'];
$username = $data['form']['username'];
$email = $data['form']['email'];
$password = $data['form']['password'];
$encoder = $this->container->get('security.password_encoder');
$encoded = $encoder->encodePassword($user, $password);
        
        // perform some action, such as saving the task to the database
        $user->setName($name);
         $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($encoded);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('adduser');
    }
}

        return $this->render('tasks/defaultaddtaskform.html.twig', array(
            'form' => $form->createView(),));
    }
    
    public function deleteuserAction()
    {
        return $this->render('users/index.html.twig');
    }
    
    /**
     *@Route("/app/user/{id}/edit",name="edituser")
     */
    
    public function edituserAction($id, Request $request)
    {
        
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        // find *all* products
            $user = $repository->findOneBy(array('id'=>$id));
            $orignalpassword = $user->getPassword();
            
              if (!$user) {
        throw $this->createNotFoundException(
            'No User found'
        );    
         }
         
          $form = $this->createFormBuilder($user)
            ->add('name', 'text')
            ->add('username', 'text')
            ->add('email','text')
                  ->add('password','password',array('required' => FALSE, 'attr' => array('placeholder' => 'Leave it blank to keep password unchanged')))
            ->add('save', 'submit', array('label' => 'Edit User Details'))
            ->getForm();
        
        $form->handleRequest($request);
if ($request->isMethod('POST')) {
    if ($form->isValid()) {
        
        $data = $request->request->all();
$name = $data['form']['name'];
$username = $data['form']['username'];
$email = $data['form']['email'];
$password = $data['form']['password'];
if(!empty($password)){
$encoder = $this->container->get('security.password_encoder');
$encoded = $encoder->encodePassword($user, $password);
}
        
        // perform some action, such as saving the task to the database
        $user->setName($name);
         $user->setUsername($username);
        $user->setEmail($email);
        if(!empty($password)){
         $user->setPassword($encoded);
        }
        else
        {
             $user->setPassword($orignalpassword);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('adduser');
    }
}

        return $this->render('tasks/defaultaddtaskform.html.twig', array(
            'form' => $form->createView(),));
        
    }
   
    
}

