<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setSlug($faker->word);
            $category->setName($faker->word);
         
            $this->addReference('category_' . $i, $category);
           
            $manager->persist($category);
        }

        $manager->flush();
    }
}
