<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    
    /**
     * @Route("/app/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render(
        'security/login.html.twig',
        array(
            // last username entered by the user
            'username' => $lastUsername,
            'error' => $error,
        )
    );
    }

    /**
     * @Route("/app/login_check", name="login_check")
     * 
     * @return type
     */
     
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
        return $this->redirectToRoute('tasks');
      
    }
    
    /**
     * @Route("/app/logout", name="logout")
     * 
     * @return type
     */
    
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
        return $this->redirectToRoute('login_route');
      
    }
     
}

