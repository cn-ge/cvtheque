<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CandidatFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        
        // $candidat = new Candidat();
        // $candidat->setCivilite(0);
        // $candidat->setEmail('jl@david.fr');
        // $candidat->setMobilite(true);
        // $candidat->setMobiliteZone('Région parisienne');
        // $candidat->setNom('David');
        // $candidat->setPrenom('Jean-Louis');
        // $candidat->setTelephone('0304050607');
        // $candidat->setTitre('coiffeur');
        // $candidat->setPosteVise('coiffeur de star');
        // $candidat->setAdresse1('Tour Montparnasse');
        // $candidat->setVille('Paris');
        // $candidat->setCp('75001');
        // $candidat->setDateNaissance(new \DateTime('10/04/1979'));
        // $candidat->setNotes('profil rencontré en mars');
        // $manager->persist($candidat);
        // $manager->flush();
        // $manager->clear(Candidat::class);


        // $candidat = new Candidat();
        // $candidat->setCivilite(1);
        // $candidat->setEmail('c.geindreau@gmail.com');
        // $candidat->setMobilite(false);
        // $candidat->setNom('geindreau');
        // $candidat->setPrenom('Carine');
        // $candidat->setTelephone('0604050607');
        // $candidat->setTitre('Développeur Fullstack');
        // $candidat->setPosteVise('Développeur PHP Symfony 4');
        // $candidat->setAdresse1('Rue renan');
        // $candidat->setVille('Nantes');
        // $candidat->setCp('44100');
        // $candidat->setDateNaissance(new \DateTime('04/27/1975'));

        // $forma1 = new Formation();
        // $forma1->setAnnee('2018');
        // $forma1->setDiplome('Manager des Systèmes d\'Information');
        // $forma1->setObtenu(true);
        // $forma1->setEcole('ENI Ecole Informatique');
        // $forma1->setVille('St Herblain-44');
        // $forma1->setAlternance(true);
        // $forma1->setNiveau(0);

        // $candidat->addFormation($forma1);

        // $forma2 = new Formation();
        // $forma2->setAnnee('2017');
        // $forma2->setDiplome('Concepteur Développeur Informatique');
        // $forma2->setObtenu(true);
        // $forma2->setEcole('ENI Ecole Informatique');
        // $forma2->setVille('St Herblain-44');
        // $forma2->setAlternance(true);
        // $forma2->setNiveau(2);

        // $candidat->addFormation($forma2);

        // $formation = new Formation();
        // $formation->setAnnee('2016');
        // $formation->setDiplome('Développeur Logiciel');
        // $formation->setObtenu(true);
        // $formation->setEcole('ENI Ecole Informatique');
        // $formation->setVille('St Herblain-44');
        // $formation->setAlternance(false);
        // $formation->setNiveau(3);

        // $candidat->addFormation($formation);

        // $formation = new Formation();
        // $formation->setAnnee('1995');
        // $formation->setDiplome('BTS Assistante de Direction');
        // $formation->setEcole('La Providence');
        // $formation->setObtenu(true);
        // $formation->setAlternance(false);
        // $formation->setNiveau(3);

        // $candidat->addFormation($formation);
        

        // $manager->persist($candidat);
        // $manager->flush();
        // $manager->clear(Candidat::class);

        $faker = Factory::create('fr_FR');

        for($i =0; $i < 100; $i++) {


            $candidat = new Candidat();
            $candidat->setCivilite(0);
            $candidat->setEmail($faker->email());
            $candidat->setMobilite($faker->boolean($chanceOfGettingTrue = 50));
            $candidat->setNom($faker->words(1, true));
            $candidat->setPrenom($faker->words(1, true));
            $candidat->setTelephone($faker->phoneNumber());
            $candidat->setTitre('Développeur Fullstack' . $i);
            $candidat->setPosteVise('Développeur PHP Symfony '. $i);
            $candidat->setAdresse1($faker->streetAddress());
            $candidat->setVille($faker->city());
            $candidat->setCp((string)rand(1000, 99500));
            $candidat->setDateNaissance($faker->dateTimeBetween($startDate = '-50 years', $endDate = '-20years'));
            $manager->persist($candidat);
            $manager->flush();
            $manager->clear(Candidat::class);
        }
        
    }
}
