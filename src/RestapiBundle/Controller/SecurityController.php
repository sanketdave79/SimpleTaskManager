<?php

# src/Acme/DemoBundle/Controller/SecurityController.php

namespace RestapiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    
    /**
     * @Route("/api/login", name="apilogin_route")
     */
    
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            $error = $error->getMessage(
            ); // WARNING! Symfony source code identifies this line as a potential security threat.
        }

        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return $this->render(
            'RestapiBundle:Security:login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
                 )
        );
    }

    /**
     * @Route("/api/login_check", name="apilogin_check")
     * 
     * @return type
     */
    
    public function loginCheckAction(Request $request)
    {

    }
    
     /**
     * @Route("/api/logout", name="apilogout")
     * 
     * @return type
     */
    
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
        return $this->redirectToRoute('apilogin_route');
      
    }
}

