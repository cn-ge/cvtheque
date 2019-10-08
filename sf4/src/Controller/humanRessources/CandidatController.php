<?php

namespace App\Controller\humanRessources;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Candidat;
use App\Repository\CandidatRepository;
use Doctrine\Common\Persistence\ObjectManager;

class CandidatController  extends AbstractController {

    private $current_menu = 'candidat';
    private $current_user = 'rh';
    private $repo;
    private $em;


    function __construct(CandidatRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }


    /**
     * @Route("/admin/candidat", name="admin.candidat.index")
     * @return Response
     */
    public function index(): Response {
        $candidats = $this->repo->findAll();
        return $this->render('admin/candidat/index.html.twig', ['candidats' => compact($candidats), 'current_menu' => 'candidat']);

    }
    /**
     * @Route("/rh/candidat/{slug}-{id}", name="rh.candidat.edit", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function edit(Candidat $candidat, string $slug): Response {
        return $this->render('admin/candidat/edit.html.twig', compact($candidat));

    }


    /**
     * @Route("/rh/candidat/{slug}-{id}", name="rh.candidat.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    // public function show($slug, $id): Response {
        // $candidat = $this->repo->find($id);
        public function show (Candidat $candidat, string $slug) : Response {
            $candidatSlug = $candidat->getSlug();
            if ($candidatSlug !== $slug) {
                return $this->redirectToRoute('candidat.show', ["slug" => $candidatSlug, "id" => $candidat->getId()], 301);
            } 
            return $this->render('candidat/show.html.twig', ['current_menu' => $this->current_menu, 'candidat' => $candidat]);
        }
}

