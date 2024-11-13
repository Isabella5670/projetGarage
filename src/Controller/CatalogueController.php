<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Créer une marque
        $marque = new Marque();
        $marque->setNomMarque('Peugeot');
        $entityManager->persist($marque); // Persist la marque

        // Créer un modèle
        $modele = new Modele();
        $modele->setNomModele('308')
            ->setMarque($marque); // Lier le modèle à la marque
        $entityManager->persist($modele); // Persist le modèle

        // Créer un véhicule
        $vehicule = new Vehicule();
        $vehicule->setImmatriculation('394493NC')
                ->setDateMiseEnCirculation(new \DateTime('2023-01-01'))
                ->setPrix(15000.00)
                ->setDateRentree(new \DateTime())
                ->setChevauxFiscaux(7)
                ->setDescription('Un véhicule en très bon état.')
                ->setModele($modele); // Lier le véhicule au modèle
        $entityManager->persist($vehicule); // Persist le véhicule

        // Flushez toutes les entités
        $entityManager->flush();

        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }

    /**
     * Fonction permettant d'afficher un seul article du catalogue
     */
    #[Route('/catalogue/12', name: 'catalogue_show')]
    public function show() {
        return $this->render('catalogue/show.html.twig');
    }
}