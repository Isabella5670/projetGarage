<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Image;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

class AdminController extends AbstractController
{
    private VoitureRepository $repository;

    public function __construct(VoitureRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $voitures = $this->repository->findAll();

        return $this->render('admin/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/admin/voiture/new', name: 'admin_voiture_new')]
    #[Route('/admin/voiture/{id}/edit', name: 'admin_voiture_edit', methods: ['GET', 'POST'])]
    public function form(Request $request, EntityManagerInterface $entityManager, Voiture $voiture = null): Response
    {
        if (!$voiture) {
            $voiture = new Voiture();
        }

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nouvelleMarque = $form->get('nouvelleMarque')->getData();
            $nouveauModele = $form->get('nouveauModele')->getData();

            // Gestion de la nouvelle marque
            if ($nouvelleMarque) {
                $marque = new Marque();
                $marque->setNomMarque($nouvelleMarque);
                $entityManager->persist($marque);
                $voiture->setMarque($marque);
            }

            // Gestion du nouveau modèle
            if ($nouveauModele) {
                $modele = new Modele();
                $modele->setNomModele($nouveauModele);

                // Si une nouvelle marque est ajoutée, associez le modèle à cette marque
                $marque = $voiture->getMarque();
                if ($marque) {
                    $modele->setMarque($marque);
                }

                $entityManager->persist($modele);
                $voiture->setModele($modele);
            }

            // Gestion des fichiers d'images
            $imageFiles = $form->get('imageFiles')->getData();
            foreach ($imageFiles as $imageFile) {
                // Crée un nom de fichier unique
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                
                // Déplace le fichier vers le répertoire d'upload
                $imageFile->move($this->getParameter('images_directory'), $newFilename);

                // Crée une nouvelle instance de l'image
                $image = new Image();
                $image->setNomImage($newFilename);
                $image->setChemin($this->getParameter('images_directory') . '/public/img/uploads' . $newFilename);
                $image->setVoiture($voiture);
                $entityManager->persist($image);
            }

            $entityManager->persist($voiture);
            $entityManager->flush();
            $this->addFlash('success', 'Action exécutée  avec succès.');

            return $this->redirectToRoute('app_admin');
        } 

        return $this->render('admin/voiture_form.html.twig', [
            'form' => $form->createView(),
            'voiture' => $voiture,
        ]);
    }

    #[Route('/admin/voiture/{id}/delete', name: 'admin_voiture_delete')]
    public function delete(EntityManagerInterface $entityManager, Voiture $voiture): Response
    {
        // Supprimer les images associées
        foreach ($voiture->getImages() as $image) {
            $imagePath = $this->getParameter('images_directory') . '/' . $image->getNomImage();
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprimer l'image du système de fichiers
            }
            $entityManager->remove($image); // Supprimer l'image de la base de données
        }

        $entityManager->remove($voiture); // Supprimer la voiture
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/voiture/{id}/image/{imageId}/delete', name: 'admin_voiture_image_delete', methods: ['POST'])]
    public function deleteImage(
        int $id,
        int $imageId,
        Request $request,
        EntityManagerInterface $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response {
        $image = $entityManager->getRepository(Image::class)->find($imageId);

        if (!$image) {
            $this->addFlash('danger', 'Image introuvable.');
            return $this->redirectToRoute('admin_voiture_edit', ['id' => $id]);
        }

        // Vérification du token CSRF
        $csrfToken = $request->request ->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete' . $image->getId(), $csrfToken))) {
            $this->addFlash('danger', 'Action non autorisée.');
            return $this->redirectToRoute('admin_voiture_edit', ['id' => $id]);
        }

        $entityManager->remove($image);
        $entityManager->flush();

        $this->addFlash('success', 'Image supprimée avec succès.');
        return $this->redirectToRoute('admin_voiture_edit', ['id' => $id]);
    }
}