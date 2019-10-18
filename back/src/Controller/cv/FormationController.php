<?php

namespace App\Controller\cv;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    const ROUTE_SHOW                = "formation.show";
    const ROUTE_ADD                 = "formation.add";
    const ROUTE_EDIT                = "formation.edit";
    const ROUTE_DELETE              = "formation.delete";
    const ROUTE_LIST                = "formation.list";
    const ROUTE_PRINT               = "formation.print";

    const TEMPLATE_EDIT_PATH        = "cv/formation/edit.html.twig";
    const TEMPLATE_ADD_PATH         = "cv/formation/add.html.twig";
    const TEMPLATE_LIST_PATH        = "cv/formation/list.html.twig";
    const TEMPLATE_SHOW_PATH        = "cv/formation/show.html.twig";

    const MENU                      = 'formation';
    /**
     * @Route("/list", name="formation.list", methods={"GET"})
     */
    public function list(FormationRepository $formationRepository): Response
    {
        return $this->render(self::TEMPLATE_LIST_PATH, [
            'formations' => $formationRepository->findByCandidat($this->getUser()),
            'menu' => self::MENU
        ]);
    }

    /**
     * @Route("/add", name="formation.add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $formation = new Formation();
        if (is_null($formation->getCandidat())) $formation->setCandidat($this->getUser());
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST);
        }

        return $this->render(self::TEMPLATE_ADD_PATH, [
            'formation' => $formation,
            'form' => $form->createView(),
            'menu' => self::MENU
        ]);
    }

    /**
     * @Route("/{id}", name="formation.show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render(self::TEMPLATE_SHOW_PATH, [
            'formation' => $formation,
            'menu' => self::MENU
        ]);
    }

    /**
     * @Route("/edit/{id}", name="formation.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(self::ROUTE_LIST);
        }

        return $this->render(self::TEMPLATE_EDIT_PATH, [
            'formation' => $formation,
            'form' => $form->createView(),
            'menu' => self::MENU    
        ]);
    }

    /**
     * @Route("/delete/{id}", name="formation.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::ROUTE_LIST);
    }
}
