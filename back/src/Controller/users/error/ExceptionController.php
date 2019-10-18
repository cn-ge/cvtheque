<?php

namespace App\Controller\users\error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ExceptionController extends AbstractController{


    /**
     * @Route("/not-found", name="error.notfound")
     * @return Response
     */
    public function notFound (Request $request, AuthenticationUtils $authenticationUtils) : Response{

        return $this->redirectToRoute('login');
    }
}