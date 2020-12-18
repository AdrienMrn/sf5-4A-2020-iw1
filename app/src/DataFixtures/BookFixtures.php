<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $users = $manager->getRepository(User::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();

        for ($i=0; $i<100; $i++) {
            shuffle($tags);

            $object = (new Book())
                ->setName($faker->name)
                ->setDescription($faker->paragraph)
                ->setAveragePrice($faker->numberBetween(5, 40))
                ->setPublicationDate($faker->dateTime)
                ->setCreator($users[array_rand($users)])
                ->setUpdatedAt($faker->dateTime)
                ->addTag($tags[0])
                ->addTag($tags[1])
            ;
            $manager->persist($object);

            if ($i % 50) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TagFixtures::class
        ];
    }
}
