<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatController {


    /**
     * @Route("/candidats", name="candidat.index")
     * @return Response
     */
    public function index (): Response {
        // return new Response('Les candidats');
        return new Response(
            '<html><body>Les candidats</body></html>'
        );
    }
}