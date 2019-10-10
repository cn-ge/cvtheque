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
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->encoder->encodePassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
        $manager->clear(User::class);

        $rh = new User();
        $rh->setUsername('hr');
        $rh->setPassword($this->encoder->encodePassword($rh, 'hr'));
        $rh->setRoles(['ROLE_HR']);
        $manager->persist($rh);
        $manager->flush();
        $manager->clear(User::class);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $admin->setRoles(['ROLE_USER', 'ROLE_HR', 'ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
        $manager->clear(User::class);
    }
}
