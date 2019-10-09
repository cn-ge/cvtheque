<?php

namespace App\Controller\auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController {


    /**
     * @Route("/login", name="auth.login")
     * @return Response
     */
    public function Login() : Response {
        return new Response($this->twig->render('home/home.html.twig', ['role' => $this->current_role]));
    }
}