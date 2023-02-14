<?php

namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create ('fr_FR');

        for ($i = 0; $i < 25; $i++) {
            $produit = new Produit();
            $produit->setNom("produit" . $i);
            $produit->setPrix(mt_rand(10,500));
            $manager->persist($produit);
        }
        $manager->flush();
    }
}
