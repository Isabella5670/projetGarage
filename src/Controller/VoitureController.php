<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index(VoitureRepository $voitureRepository): Response
    {
        // Récupérer toutes les voitures
        $voitures = $voitureRepository->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/voiture/{id}', name: 'voiture_detail')]
    public function detail(Voiture $voiture): Response
    {
        return $this->render('voiture/detail.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}