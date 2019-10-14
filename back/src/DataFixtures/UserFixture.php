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
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('user@user.fr');
        $password = 'user';
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $manager->persist($user);
        $manager->flush();
        $manager->clear(User::class);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@admin.fr');
        $password = 'admin';
        $admin->setPassword($this->encoder->encodePassword($admin, $password));
        $manager->persist($admin);
        $manager->flush();
        $manager->clear(User::class);

        $hr = new User();
        $hr->setRoles(['ROLE_HR']);
        $hr->setEmail('hr@hr.fr');
        $password = 'hr';
        $hr->setPassword($this->encoder->encodePassword($hr, $password));
        $manager->persist($hr);
        $manager->flush();
        $manager->clear(User::class);
    }
}
