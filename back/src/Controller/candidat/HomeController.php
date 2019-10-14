<?php

namespace App\Controller\candidat;

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
     * @Route("/candidat", name="candidat.home")
     * @return Response
     */
    public function index (): Response {
        return new Response($this->twig->render('candidat/home.html.twig'));
    }
}