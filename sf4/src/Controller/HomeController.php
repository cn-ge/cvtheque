<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    private $current_menu = null;
    private $current_user = null;
    private $current_role = null;

    /**
     * @var Environnement
     * Variable de type service
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index (): Response {
        if ($this->getUser() != null) {
            $roles = $this->getUser()->getRoles();
            return new Response('<html>user role</html>');
        }
        return $this->redirect('/login');
    }
}