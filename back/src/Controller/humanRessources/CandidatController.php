<?php

namespace App\Controller\humanRessources;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;


use Dompdf\Dompdf;
use Dompdf\Options;

class CandidatController  extends AbstractController {

    const ROUTE_ADD                 = "hr.candidat.add";
    const ROUTE_SHOW                = "hr.candidat.show";
    const ROUTE_EDIT                = "hr.candidat.edit";
    const ROUTE_DELETE              = "hr.candidat.delete";
    const ROUTE_LIST                = "hr.candidat.list";
    const ROUTE_PRINT               = "hr.candidat.print";
    const ROUTE_HTML                = "hr.candidat.html";

    const TEMPLATE_ADD_PATH         = "humanRessources/candidat/add.html.twig";
    const TEMPLATE_SHOW_PATH        = "humanRessources/candidat/show.html.twig";
    const TEMPLATE_EDIT_PATH        = "humanRessources/candidat/edit.html.twig";
    const TEMPLATE_LIST_PATH        = "humanRessources/candidat/list.html.twig";
    const TEMPLATE_PDF_PATH         = "humanRessources/candidat/pdf.html.twig";
    const TEMPLATE_HTML_PATH        = "humanRessources/candidat/html.html.twig";

    const MENU                      = 'candidat';

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
    public function list(PaginatorInterface $paginator, Request $request): Response {
        $candidats = $paginator->paginate(
            $this->repo->findAll(),
            $request->query->getInt('page', 1),
            8
        );    
        // $candidats = $this->repo->findAll();
        return $this->render(self::TEMPLATE_LIST_PATH, ['candidats' => $candidats, 'menu' => self::MENU]);
    }

    /**
     * @Route("/human-ressources/candidat/show/{slug}-{id}", name="hr.candidat.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Candidat $candidat, string $slug) : Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();
        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_SHOW, ["slug" => $candidatSlug, "id" => $id, 'menu' => self::MENU], 301);
        } 
        if ($candidat != null) {
            return $this->render(self::TEMPLATE_SHOW_PATH, ['menu' => self::MENU, 'candidat' => $candidat]);
        }
    }

    /**
     * @Route("/human-ressources/candidat/edit/{slug}-{id}", name="hr.candidat.edit", requirements={"slug": "[a-z0-9\-]*"}, methods="GET|POST")
     * @return Response
     */
    public function edit(Candidat $candidat, string $slug, Request $request): Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();

        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_EDIT, ["slug" => $candidatSlug, "id" => $id, 'menu' => self::MENU], 301);
        } 

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash("success", 'Candidat modifié avec succès !');
            return $this->redirectToRoute(self::ROUTE_LIST, ['menu' => self::MENU]);
        }

        return $this->render(self::TEMPLATE_EDIT_PATH, ['candidat' => $candidat, 'form' => $form->createView(), 'menu' => self::MENU]);
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
            return $this->redirectToRoute(self::ROUTE_LIST, ['menu' => self::MENU]);
        }

        return $this->render(self::TEMPLATE_ADD_PATH, ['candidat' => $candidat, 'form' => $form->createView(), 'menu' => self::MENU]);
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
        return $this->redirectToRoute(self::ROUTE_LIST, ['menu' => self::MENU]);
    }
    /**
     * @Route("/human-ressources/candidat/html/{slug}-{id}", name="hr.candidat.html", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function showHtml(Candidat $candidat, string $slug): Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();

        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_HTML, ["slug" => $candidatSlug, "id" => $id, 'menu' => self::MENU], 301);
        } 
        return $this->render(self::TEMPLATE_HTML_PATH, ['candidat' => $candidat]);
    }

    /**
     * @Route("/human-ressources/candidat/print/{slug}-{id}", name="hr.candidat.print", requirements={"slug": "[a-z0-9\-]*"}, methods="GET|POST")
     * @return Response
     */
    public function print(Candidat $candidat, string $slug): Response {
        $candidatSlug = $candidat->getSlug();
        $id = $candidat->getId();

        if ($candidatSlug !== $slug) {
            return $this->redirectToRoute(self::ROUTE_PRINT, ["slug" => $candidatSlug, "id" => $id, 'menu' => self::MENU], 301);
        } 

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->setBasePath(realpath(dirname(dirname(dirname(__DIR__))).'/public/css/html_pdf.css'));
        // return new Response(dirname(dirname(dirname(__DIR__))).'/public/css/html_pdf.css');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView(self::TEMPLATE_PDF_PATH, [ 'candidat' => $candidat ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false // Show in browser
        ]);


    }
}

