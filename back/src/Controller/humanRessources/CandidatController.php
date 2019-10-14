<?php

namespace App\Controller\humanRessources;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class CandidatController  extends AbstractController {

    private $current_menu = 'candidat';
    private $current_role = 'hr';
    private $repo;
    private $em;


    function __construct(CandidatRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/human-ressources/candidats", name="hr.candidat.list")
     * @return Response
     */
    public function index(): Response {
        $candidats = $this->repo->findAll();
        return $this->render('humanRessources/candidat/list.html.twig', ['candidats' => $candidats, 'current_menu' => $this->current_menu, 'current_role' => $this->current_role]);
    }

    /**
     * @Route("/human-ressources/candidat/show/{slug}-{id}", name="hr.candidat.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Candidat $candidat, string $slug) : Response {
        $candidatSlug = $candidat->getSlug();
        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute('hr.candidat.show', ["slug" => $candidatSlug, "id" => $candidat->getId()], 301);
        } 
        return $this->render('humanRessources/candidat/show.html.twig', ['current_menu' => $this->current_menu, 'current_role' => $this->current_role, 'candidat' => $candidat]);
    }

    /**
     * @Route("/human-ressources/candidat/edit/{slug}-{id}", name="hr.candidat.edit", requirements={"slug": "[a-z0-9\-]*"}, methods="GET|POST")
     * @return Response
     */
    public function edit(Candidat $candidat, string $slug, Request $request): Response {
        $candidatSlug = $candidat->getSlug();
        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute('hr.candidat.edit', ["slug" => $candidatSlug, "id" => $candidat->getId()], 301);
        } 
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);
        // return new Response('<html>'. $request .'</html>');

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash("success", 'Candidat modifié avec succès !');
            return $this->redirectToRoute('hr.candidat.list', ['current_menu' => $this->current_menu, 'current_role' => $this->current_role]);
        }
        return $this->render('humanRessources/candidat/edit.html.twig', ['candidat' => $candidat, 'form' => $form->createView(), 'current_menu' => $this->current_menu, 'current_role' => $this->current_role]);

    }

    /**
     * @Route("/human-ressources/candidat/add", name="hr.candidat.add")
     * @return Response
     */
    public function add(Request $request): Response {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($candidat);
            $this->em->flush();
            $this->addFlash("success", 'Candidat créé avec succès !');
            return $this->redirectToRoute('hr.candidat.list', ['current_menu' => $this->current_menu, 'current_role' => $this->current_role]);
        }
        return $this->render('humanRessources/candidat/add.html.twig', ['candidat' => $candidat, 'form' => $form->createView(), 'current_menu' => $this->current_menu, 'current_role' => $this->current_role]);
    }

    /**
     * @Route("/human-ressources/candidat/delete/{id}", name="hr.candidat.delete", methods="DELETE")
     * @return Response
     */
    public function delete(Candidat $candidat, Request $request): Response {
        if ($this->isCsrfTokenValid('delete' . $candidat->getId(), $request->get('_token'))) {
            $this->em->remove($candidat);
            $this->em->flush();
            $this->addFlash("success", 'Candidat supprimé !');
        }
        return $this->redirectToRoute('hr.candidat.list', ['current_menu' => $this->current_menu, 'current_role' => $this->current_role]);
    }
}

