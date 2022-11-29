<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private const USERS = [
        [
            'email' => 'depoorter.franck@gmail.com',
            'roles' => [],
            'password' => '$2y$13$mSH1Gki2pUgkxVYtBrGH8.vfbiFFmylw.VoP5kCbejQ.ky/JXrbHy',
            'firstname' => 'FRANCK',
            'lastname' => 'DEPOORTER',
            'address' => '29 RUE DE LA PANNERIE',
            'zipcode' => 59840,
            'city' => 'PÈRENCHIES',
            'slug' => 'user1',
        ],
        [
            'email' => 'franck@gmail.com',
            'roles' => [],
            'password' => '$2y$13$hp5Y81KQQw9GDCwT9LYB2eApj47AFZN.v/vE44.DDdAU3zUylr5Km',
            'firstname' => 'robert',
            'lastname' => 'jean',
            'address' => '12 rue de la paix',
            'zipcode' => 59000,
            'city' => 'Lille',
            'slug' => 'user2',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userInfo) {
            $user = new User();
            $user->setRoles($userInfo['roles']);
            $user->setEmail($userInfo['email']);
            $user->setPassword($userInfo['password']);
            $user->setFirstname($userInfo['firstname']);
            $user->setLastname($userInfo['lastname']);
            $user->setAddress($userInfo['address']);
            $user->setZipcode($userInfo['zipcode']);
            $user->setCity($userInfo['city']);
            $manager->persist($user);
            $this->addReference('user' . $userInfo['slug'], $user);
        };
        $manager->flush();
    }
}
