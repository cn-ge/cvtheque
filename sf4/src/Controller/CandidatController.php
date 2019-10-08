<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Candidat;
use App\Repository\CandidatRepository;
use Doctrine\Common\Persistence\ObjectManager;

class CandidatController  extends AbstractController {

    
    private $current_menu = 'candidat';
    private $repo;
    private $em;


    function __construct(CandidatRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/candidats", name="candidat.index")
     * @return Response
     */
    public function index (): Response {

        // $this->addCandidats();

        // $repo = $this->getDoctrine()->getRepository(Candidat::class);
        // $candidat = $this->repo->find(1);
        // $candidat = $this->repo->findOneBy(['nom' => 'geindreau']);
        // $candidats = $this->repo->findAll();

        // $candidats = $this->repo->findAllByNom('geindreau');
        $candidats = $this->repo->findAll();
        // $candidats[0]->setEmail('c.geindreau.wemoov@gmail.com');
        // $this->em->flush();
        // dump($repo);

        return $this->render('candidat/index.html.twig', ['current_menu' => $this->current_menu, 'candidats' => $candidats]);
    }


    /**
     * @Route("/candidats/{slug}-{id}", name="candidat.show", requirements={"slug": "[a-z0-9\-]*"})
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


    private function addCandidats() {

        $candidat = new Candidat();
        $candidat->setNom('david')
                ->setPrenom('Jean-Louis')
                ->setTelephone('0616616024')
                ->setEmail('jl-david@gmail.com')
                ->setCp(75000)
                ->setVille('Paris')
                ->setPosteVise('Intégrateur')
                ->setTitre('ingénieur étude informatique')
                ->setDateNaissance(new \Datetime('09/10/1999'))
                ->setCivilite(1);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($candidat);
        $em->flush();


        $candidat = new Candidat();
        $candidat->setNom('  geindreau  ')
                ->setPrenom('carine')
                ->setTelephone('0616616023')
                ->setEmail('c.geindreau@gmail.com  ')
                ->setCp(44100)
                ->setVille('Nantes')
                ->setPosteVise('Développeur FullStack')
                ->setTitre('Ingénieur d’études & Développement')
                ->setDateNaissance(new \Datetime('04/27/1979'))
                ->setCivilite(1);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($candidat);
        $em->flush();
    }   