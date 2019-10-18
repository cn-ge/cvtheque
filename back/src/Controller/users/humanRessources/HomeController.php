<?php

namespace App\Controller\users\humanRessources;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{


    const TEMPLATE_HOME_PATH        = "users/humanRessources/home.html.twig";
    
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
     * @Route("/ressources-humaines", name="hr.home")
     * @return Response
     */
    public function index (UserRepository $repo): Response {
        $candidats = $repo->findLatest();
        return new Response($this->twig->render(self::TEMPLATE_HOME_PATH, [
            'candidats' => $candidats,
            'current_menu' => self::CURRENT_MENU,
            ]
        ));
    }
}