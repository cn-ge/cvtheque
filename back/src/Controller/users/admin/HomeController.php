<?php

namespace App\Controller\users\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    const TEMPLATE_HOME_PATH        = "users/admin/home.html.twig";
    
    const CURRENT_MENU              = 'home';
    
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
     * @Route("/admin", name="admin.home")
     * @return Response
     */
    public function index (): Response {
        return new Response($this->twig->render(self::TEMPLATE_HOME_PATH, [
            'current_menu' => self::CURRENT_MENU
            ]
        ));
    }
}