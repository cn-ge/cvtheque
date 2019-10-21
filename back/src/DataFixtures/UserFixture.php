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
    }
}
