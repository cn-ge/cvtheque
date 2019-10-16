<?php

namespace App\Controller\humanRessources;

use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{


    const TEMPLATE_HOME_PATH        = "humanRessources/home.html.twig";

    private $current_menu = 'home';
    private $current_role = 'hr';

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
     * @Route("/human-ressources", name="hr.home")
     * @return Response
     */
    public function index (CandidatRepository $repo): Response {
        $candidats = $repo->findLatest();
        return new Response($this->twig->render(self::TEMPLATE_HOME_PATH, ['candidats' => $candidats, 'current_menu' => $this->current_menu, 'current_role' => $this->current_role]));
    }
}