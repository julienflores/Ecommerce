<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsFixtures extends Fixture
{   
    public function __construct(private SluggerInterface $slugger)
    {   
        
    }
    

    public function load(ObjectManager $manager): void
    {   $faker = \Faker\Factory::create('fr_FR');
        for($i=0;$i<10;$i++){
            $product = new Products();
            $product->setName($faker->text(15));
            $product->setDescription($faker->text());
            $product->setPrice($faker->numberBetween(900,150000));
            $product->setStock($faker->numberBetween(0,10));
            //On va chercher une référence de catégorie
            $category = $this->getReference('category_'.$faker->numberBetween(1,6));
            $product->setCategories($category);
            $product->setSlug($this->slugger->slug($product->getName())->lower());

            $this->setReference('product_'.$i, $product);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
