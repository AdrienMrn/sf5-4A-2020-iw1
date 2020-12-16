<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $tags = [];
        for ($i=0; $i<20; $i++) {
           $tags[] = $faker->safeColorName;
        }
        $tags = array_unique($tags);

        foreach ($tags as $tag) {
            $object = (new Tag())
                ->setName($tag)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
