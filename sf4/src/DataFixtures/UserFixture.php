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
        $user->setEmail('user@user.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'user'));
        $user->setIsActive(1);
        $user->addRole(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
        $manager->clear(User::class);

        $admin = new User();
        $admin->setEmail('admin@admin.fr');
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $admin->setIsActive(1);
        $admin->addRole(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
        $manager->clear(User::class);

        $hr = new User();
        $hr->setEmail('rh@rh.fr');
        $hr->setPassword($this->encoder->encodePassword($hr, 'rh'));
        $hr->setIsActive(1);
        $hr->addRole(['ROLE_HR']);
        $manager->persist($hr);
        $manager->flush();
        $manager->clear(User::class);
    }
}
