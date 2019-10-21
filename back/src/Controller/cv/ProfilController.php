<?php

namespace App\Controller\cv;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Formation;
use App\Entity\UserSearch;
use App\Form\CandidatType;
use App\Form\UserSearchType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;


use Dompdf\Dompdf;
use Dompdf\Options;

class ProfilController  extends AbstractController {
    
    const ROUTE_SHOW                = "profil.show";
    const ROUTE_EDIT                = "profil.edit";
    const ROUTE_DELETE              = "profil.delete";
    const ROUTE_LIST                = "profil.list";
    const ROUTE_PRINT               = "profil.print";

    const TEMPLATE_EDIT_PATH        = "cv/profil/edit.html.twig";
    const TEMPLATE_LIST_PATH        = "cv/profil/list.html.twig";
    const TEMPLATE_SHOW_PATH        = "cv/profil/show.html.twig";
    const TEMPLATE_PRINT_PATH       = "cv/print.html.twig";

    const MENU                      = 'profil';

    private $repo;
    private $em;
    private $role;


    function __construct(UserRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/profil/candidats", name="profil.list")
     * @return Response
     */
    public function list(PaginatorInterface $paginator, Request $request): Response {

        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $candidats = $paginator->paginate(
            $this->repo->findAllcandidats($search),
            $request->query->getInt('page', 1),
            8
        );    
        // $candidats = $this->repo->findAll();
        return $this->render(self::TEMPLATE_LIST_PATH, [
            'candidats' => $candidats,
            'menu' => self::MENU,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil/show/{slug}-{id}", name="profil.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(User $candidat, string $slug) : Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();
        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_SHOW, [
                "slug" => $candidatSlug, 
                "id" => $id, 
                'menu' => self::MENU
            ], 301);
        } 
        if ($candidat != null) {
            return $this->render(self::TEMPLATE_SHOW_PATH, [
                'menu' => self::MENU,
                'candidat' => $candidat
            ]);
        }
    }

    /**
     * @Route("/profil/edit/{slug}-{id}", name="profil.edit", requirements={"slug": "[a-z0-9\-]*"}, methods="GET|POST")
     * @return Response
     */
    public function edit(User $candidat, string $slug, Request $request): Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();

        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_EDIT, [
                "slug" => $candidatSlug,
                "id" => $id,
                'menu' => self::MENU
        ], 301);
        } 

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash("success", 'User modifié avec succès !');
            return $this->redirectToRoute(self::ROUTE_LIST, [
                'menu' => self::MENU
            ]);
        }

        return $this->render(self::TEMPLATE_EDIT_PATH, [
            'candidat' => $candidat,
            'form' => $form->createView(),
            'menu' => self::MENU
        ]);
    }

    /**
     * @Route("/profil/delete/{id}", name="profil.delete", methods="DELETE")
     * @return Response
     */
    public function delete(User $candidat, Request $request): Response {
        if ($this->isCsrfTokenValid('delete' . $candidat->getId(), $request->get('_token'))) {
            $this->em->remove($candidat);
            $this->em->flush();
            $this->addFlash("success", 'User supprimé !');
        }
        return $this->redirectToRoute(self::ROUTE_LIST, [
            'menu' => self::MENU
        ]);
    }
    /**
     * @Route("/profil/print/{slug}-{id}", name="profil.print", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function showHtml(User $candidat, string $slug): Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();

        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_PRINT, [
                "slug" => $candidatSlug,
                "id" => $id,
                'menu' => self::MENU
            ], 301);
        } 
        return $this->render(self::TEMPLATE_PRINT_PATH, ['candidat' => $candidat,
        'role' => $this->role]);
    }
}

