<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    // const PWD = test
    private const PWD = '$argon2id$v=19$m=65536,t=4,p=1$kEOrN5c9/jAtfTmWWwdgqw$ZmZuVlQSkIWNwfUIuxUfTQKH/Pz28gznYeVVCTwbkq4';

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $object = (new User())
            ->setEmail("dev@technique")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword(self::PWD)
        ;
        $manager->persist($object);

        for ($i=0; $i<20; $i++) {
            $object = (new User())
                ->setEmail($faker->email)
                ->setRoles([])
                ->setPassword(self::PWD)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
