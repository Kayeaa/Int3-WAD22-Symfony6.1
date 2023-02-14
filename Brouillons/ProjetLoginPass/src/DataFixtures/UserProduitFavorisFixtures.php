<?php

namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\User;

use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserProduitFavorisFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $rep = $manager->getRepository(Produit::class);
        $produits = $rep->findAll();
        
        $rep = $manager->getRepository(User::class);
        $users = $rep->findAll();
        
        foreach ($produits as $produit){
            $produit->addLiker( $users [mt_rand (0,count($users)-1) ] );
        }
        $manager->flush();
    }
}
