<?php

namespace App\Controller;

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
        $path = getcwd();
        return new Response($this->twig->render('pages/home.html.twig', ['candidats' => $candidats, 'path' => $path]));
        // return new Response('test');
    }
}