<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++) {
            $category = new Category();
            $category->setName('Category: ' . $i);
            $category->setDescription('Lorem ipsum');
            $category->setCreatedAt(new \DateTime('now'));

            $manager->persist($category);

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
