<?php

namespace App\Controller\users\candidat;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    const TEMPLATE_HOME_PATH        = "users/candidat/home.html.twig";
    
    const CURRENT_MENU              = 'home';

    /**
     * @var Environnement
     * Variable de type service
     */
    private $twig;

    private $manager;

    public function __construct(Environment $twig, ObjectManager $manager)
    {
        $this->twig = $twig;
        $this->manager = $manager;
    }

    /**
     * @Route("/candidat", name="candidat.home")
     * @return Response
     */
    public function index (): Response {
        
        return new Response($this->twig->render(self::TEMPLATE_HOME_PATH, [
            'candidat' => $this->getUser(),
            'menu' => self::CURRENT_MENU
            ]
        ));
    }
}