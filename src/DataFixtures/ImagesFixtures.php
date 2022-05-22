<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker= \Faker\Factory::create('fr_FR');
        for($i=0;$i<10;$i++){
            $image = new Images();
            $image->setName($faker->image(null,640,480));
            //$image->setPath($faker->imageUrl());
        
            $image->setProducts($this->getReference('product_'.$faker->numberBetween(0,9)));
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductsFixtures::class,
        ];
    }
}
