<?php

namespace App\Controller\security;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController{


    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function login (Request $request, AuthenticationUtils $authenticationUtils) : Response{

      if (is_null($this->getUser())) {
        //Récupères les erreurs de connexion s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // Récupères l'identifiant rentré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
    
        return $this->render('common/login.html.twig', array(
            'email' => $lastUsername,
            'error'         => $error,
        ));
      } else {
        //Récupères les rôle de l'utilisateur
        $roles = $this->getUser()->getRoles();
        $profil = 'candidat';
        if (in_array('ROLE_ADMIN', $roles)) {
          $profil = 'admin';
        } else if (in_array('ROLE_HR', $roles)) {
          $profil = 'hr';
        }
        return $this->redirectToRoute($profil . '.home');
      }
    }

    /**
     * @Route("/logout", name="logout")
     * @return Response
     */
    public function logout (Request $request, AuthenticationUtils $authenticationUtils) : Response {
      return $this->redirectToRoute('login');
    }

    // /**
    //  * @Route("/dispatch", name="dispatch")
    //  * @return Response
    //  */
    // public function dispatch (Request $request) : Response{

    //   if (is_null($this->getUser())) {
    //     return $this->redirectToRoute('login');
    //   } else {
    //   }
    // }
}