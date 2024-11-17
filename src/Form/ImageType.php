<?php

//src/Form/ImageType.php
namespace App\Form;

use App\Entity\Image;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Le champ pour télécharger l'image
        $builder->add('nomImage', FileType::class, [
            'label' => 'Télécharger une image',
            'mapped' => false,  // Nous ne lierons pas directement ce champ à l'entité (car c'est un fichier)
            'constraints' => [
                new File([
                    'maxSize' => '2M',  // Taille maximale de fichier
                    'mimeTypes' => ['image/jpeg', 'image/png'],  // Types MIME autorisés
                    'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG ou PNG).',
                ])
            ],
        ]);

        // Le champ pour associer une voiture à l'image
        $builder->add('voiture', EntityType::class, [
            'class' => Voiture::class,
            'choice_label' => 'id',  // Afficher l'ID de la voiture
            'required' => true,      // Le champ voiture est obligatoire
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,  // L'entité associée à ce formulaire
        ]);
    }
}
