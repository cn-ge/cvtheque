<?php

namespace App\Controller\humanRessources;

use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

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
    public function index (CandidatRepository $repo): Response {
        $candidats = $repo->findLatest();
        return new Response($this->twig->render('home/home.html.twig', ['candidats' => $candidats]));
        // return new Response('test');
    }
}