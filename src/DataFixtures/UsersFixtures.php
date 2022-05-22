<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{   
    public function __construct(private UserPasswordHasherInterface $passwordEncoder,private SluggerInterface $slugger)
    {
        
       
    }


    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('flores.julien@hotmail.fr');
        $admin->setLastname('Flores');
        $admin->setFirstname('Julien');
        $admin->setAddress('1 rue de la paix');
        $admin->setZipcode('75000');
        $admin->setCity('Paris');
        $admin->setPassword($this->passwordEncoder->hashPassword( $admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $faker = \Faker\Factory::create('fr_FR');

        for($i = 0; $i < 5; $i++)
        {
            $user = new Users();
            $user->setEmail("user".$i."@mail.com");
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->address);
            $user->setZipcode($faker->postcode);
            $user->setCity(str_replace(' ','',$faker->city));
            $user->setPassword($this->passwordEncoder->hashPassword( $user, 'user'.$i));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }


        $manager->flush();
    }
}
