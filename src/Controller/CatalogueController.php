<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Vehicule;
use App\Repository\VehiculeRepository; // Assurez-vous que c'est bien ce namespace
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    private $repository;

    public function __construct(VehiculeRepository $vehiculeRepository) // Injectez le bon repository
    {
        $this->repository = $vehiculeRepository; // Utilisez le repository injecté
    }

    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(): Response
    {
        $vehicules = $this->repository->findAll(); // Récupérer tous les véhicules
        return $this->render('catalogue/index.html.twig', [
            'vehicules' => $vehicules,
            'controller_name' => 'CatalogueController',
        ]);
    }

    #[Route('/catalogue/{id}', name: 'catalogue_show')]
    public function show(int $id): Response
    {
        $vehicule = $this->repository->find($id);

        if (!$vehicule) {
            throw $this->createNotFoundException('Véhicule non trouvé');
        }

        return $this->render('catalogue/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }
}