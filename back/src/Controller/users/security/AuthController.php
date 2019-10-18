<?php

namespace App\Controller\users\security;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController{

    const TEMPLATE_LOGIN            = "users/login.html.twig";
    const TEMPLATE_REGISTER         = "users/register.html.twig";

    
    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function login (AuthenticationUtils $authenticationUtils) : Response{
      if (is_null($this->getUser())) {
        //Récupères les erreurs de connexion s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // Récupères l'identifiant rentré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
    
        return $this->render(self::TEMPLATE_LOGIN, array(
            'email' => $lastUsername,
            'error' => $error,
        ));
      } else {
        //Récupères les rôle de l'utilisateur
        $roles = $this->getUser()->getRoles();
        
        if (in_array('ROLE_ADMIN', $roles)) {
          $profil = 'admin';
        } else if (in_array('ROLE_HR', $roles)) {
          $profil = 'hr';
        } else {
          $profil = 'candidat';
        }

        return $this->redirectToRoute($profil . '.home');
      }
    }

    /**
     * @Route("/logout", name="logout")
     * @return Response
     */
    public function logout () : Response
    {
      return $this->redirectToRoute('login');
    }


    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->addRole('ROLE_USER');
            $user->setIsActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            

            return $this->redirectToRoute('candidat.home');
        }

        return $this->render('users/register.html.twig', [ 'form' => $form->createView() ]);
  }
}