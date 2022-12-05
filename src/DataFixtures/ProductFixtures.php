<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setName($faker->word);
            $product->setQuantity($faker->randomDigit);
            $product->setPrice($faker->randomDigit);
            $product->setVat($faker->randomDigit);
            $product->setShortDescription("lorem ipsum");
            $product->setDescription("lorem ipsum");
            $product->setCategory($this->getReference('category_' . $faker->numberBetween(0, 9)));
           
            $manager->persist($product);
        }

        $manager->flush();
    }
}
