<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->addRole('ROLE_USER');
        $user->setEmail('user@user.fr');
        $password = '0000';
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $manager->persist($user);
        $manager->flush();
        $manager->clear(User::class);

        $admin = new User();
        $admin->addRole('ROLE_ADMIN');
        $admin->setEmail('admin@admin.fr');
        $password = '0000';
        $admin->setPassword($this->encoder->encodePassword($admin, $password));
        $manager->persist($admin);
        $manager->flush();
        $manager->clear(User::class);

        $hr = new User();
        $hr->addRole('ROLE_HR');
        $hr->setEmail('hr@hr.fr');
        $password = 'OOOO';
        $hr->setPassword($this->encoder->encodePassword($hr, $password));
        $manager->persist($hr);
        $manager->flush();
        $manager->clear(User::class);

        $cg = new User();
        $cg->addRole('ROLE_USER');
        $cg->setEmail('c.geindreau@gmail.com');
        $password = 'OOOO';
        $cg->setPassword($this->encoder->encodePassword($cg, $password));
        $cg->setCivilite(1);
        $cg->setNom('geindreau');
        $cg->setPrenom('carine');
        $cg->setAdresse1('34b rue Renan');
        $cg->setCp('44000');
        $cg->setVille('nantes');
        $cg->setTelephone('0616616023');
        $cg->setSt('INGÉNIEUR ETUDE & DÉVELOPPEMENT');
        $cg->setPosteRecherche('DÉVELOPPEUR FULLSTACK');
        $cg->setDateNaissance(new \DateTime('04/27/1975 00:00'));
        $manager->persist($cg);
        $manager->flush();
        $manager->clear(User::class);
    }
}
