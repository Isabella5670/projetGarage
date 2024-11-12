<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'current_menu' => 'CatalogueController',
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
