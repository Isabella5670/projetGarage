<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vehicule;

class VehiculeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i<= 10;$i++) {
            $vehicule = new Vehicule();
            $vehicule->setImmatriculation("Vehicule n$i : XXX XXX NC")
                     ->setDescription("<p>Mettre les informations supplémentaires sur le véhicule</p>");
        }

        $manager->flush();
    }
}
