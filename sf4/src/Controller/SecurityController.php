<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController  extends AbstractController {


    /**
     * @Route("/login", name="security.login")
     * @return Response
     */
    public function login (AuthenticationUtils $authUtils): Response {
        $lastEmail = $authUtils->getLastUsername();
        $error = $authUtils->getLastAuthenticationError();
        return $this->render('common/login.html.twig', ['last_email' => $lastEmail, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="security.logout")
     * @return Response
     */
    public function logout (AuthenticationUtils $authUtils): Response {
        
        return $this->redirect('/login');
    }
}
