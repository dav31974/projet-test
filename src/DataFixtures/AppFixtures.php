<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');  // librairie permettant de generer des données réalistes

        $noms = [
            "Francis lebon",
            "Thomas Renaud",
            "Julie clerc",
            "Cecile Fernand",
            "Gregory Gillet",
            "Cedric Roque",
            "Laura Tulle",
            "Benoit Sisko",
            "Marianne Bellet",
            "Yann Aquin"
        ];

        for ($p = 1; $p < 10; $p++) {  // boucle permettant d'instancier et hydrater plusieurs objets (10) de la classe Personne
            $personne = new Personne();  // instanciation de la classe personne
            $personne->setNom($noms[$p])
                ->setBirthAt($faker->dateTime())
                ->setTaille(mt_rand(150, 200))  // taille aléatoire compris entre 150 et 200 cm
                ->setNbreFrereSoeur(mt_rand(0, 5))
                ->setCodePostal(mt_rand(10000, 75000))
                ->setInfos("Infos supp..");
            $manager->persist($personne);
        }

        $manager->flush();
    }
}
