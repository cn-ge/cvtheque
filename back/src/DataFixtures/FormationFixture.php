<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormationFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $formation = new Formation();
        $formation->setCandidatId(2);
        $formation->setAnnee('2018');
        $formation->setDiplome('Manager des Systèmes d\'Information');
        $formation->setObtenu(true);
        $formation->setEcole('ENI Ecole Informatique');
        $formation->setVille('St Herblain-44');
        $formation->setAlternance(true);
        $formation->setNiveau(0);
        $manager->persist($formation);
        $manager->flush();
        $manager->clear(Formation::class);


        $formation = new Formation();
        $formation->setCandidatId(2);
        $formation->setAnnee('2017');
        $formation->setDiplome('Concepteur Développeur Informatique');
        $formation->setObtenu(true);
        $formation->setEcole('ENI Ecole Informatique');
        $formation->setVille('St Herblain-44');
        $formation->setAlternance(true);
        $formation->setNiveau(2);
        $manager->persist($formation);
        $manager->flush();
        $manager->clear(Formation::class);


        $formation = new Formation();
        $formation->setCandidatId(2);
        $formation->setAnnee('2016');
        $formation->setDiplome('Développeur Logiciel');
        $formation->setObtenu(true);
        $formation->setEcole('ENI Ecole Informatique');
        $formation->setVille('St Herblain-44');
        $formation->setAlternance(false);
        $formation->setNiveau(3);
        $manager->persist($formation);
        $manager->flush();
        $manager->clear(Formation::class);


        $formation = new Formation();
        $formation->setCandidatId(2);
        $formation->setAnnee('1995');
        $formation->setDiplome('BTS Assistante de Direction');
        $formation->setObtenu(true);
        $formation->setEcole('ENI Ecole Informatique');
        $formation->setVille('St Herblain-44');
        $formation->setAlternance(false);
        $formation->setNiveau(3);
        $manager->persist($formation);
        $manager->flush();
        $manager->clear(Formation::class);
    }
}
