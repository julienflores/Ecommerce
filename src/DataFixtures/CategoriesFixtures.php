<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{   
    private $counnter = 1;
    public function __construct(private SluggerInterface $slugger)
    {
        
    }
    

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory(name:'Tableaux',manager: $manager);
        $category= $this->createCategory(name:'Bijoux',parent: null,manager: $manager);
        $category1= $this->createCategory(name:'Picasso',parent: $parent,manager: $manager);
        $category2= $this->createCategory(name:'Magritte',parent: $parent,manager: $manager);
        $category3= $this->createCategory(name:'Rembrandt',parent: $parent,manager: $manager);
        $category4= $this->createCategory(name:'Vases',parent: null,manager: $manager);
       

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($name)->lower());
        $category->setParent($parent);
        $manager->persist($category);
        $this->addReference('category_'.$this->counnter, $category);
        $this->counnter++;
        return $category; 
    }
}
