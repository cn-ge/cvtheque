<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class CandidatFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i <100; $i++) 
        $candidat = new Candidat();
        $candidat->setCivilite(0);
        $candidat->setEmail('jl@david.fr');
        $candidat->setMobilite(true);
        $candidat->setMobiliteZone('Région parisienne');
        $candidat->setNom('David');
        $candidat->setPrenom('Jean-Louis');
        $candidat->setTelephone('0304050607');
        $candidat->setTitre('coiffeur');
        $candidat->setPosteVise('coiffeur de star');
        $candidat->setAdresse1('Tour Montparnasse');
        $candidat->setVille('Paris');
        $candidat->setCp('75001');
        $candidat->setDateNaissance(new \DateTime('10/04/1979'));
        $candidat->setNotes('profil rencontré en mars');
        $manager->persist($candidat);
        $manager->flush();
        $manager->clear(Candidat::class);


        $candidat = new Candidat();
        $candidat->setCivilite(1);
        $candidat->setEmail('c.geindreau@gmail.com');
        $candidat->setMobilite(false);
        $candidat->setNom('geindreau');
        $candidat->setPrenom('Carine');
        $candidat->setTelephone('0604050607');
        $candidat->setTitre('Développeur Fullstack');
        $candidat->setPosteVise('Développeur PHP Symfony 4');
        $candidat->setAdresse1('Rue renan');
        $candidat->setVille('Nantes');
        $candidat->setCp('44100');
        $candidat->setDateNaissance(new \DateTime('04/27/1975'));
        $manager->persist($candidat);
        $manager->flush();
        $manager->clear(Candidat::class);
    }
}
