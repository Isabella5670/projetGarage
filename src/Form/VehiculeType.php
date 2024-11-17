<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Marque;
use App\Entity\Modele;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('immatriculation', TextType::class)
        ->add('prix', MoneyType::class)
        ->add('dateMiseEnCirculation', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('dateRentreGarage', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('nbPlaces', IntegerType::class)
        ->add('typeBoiteVitesse', ChoiceType::class, [
            'choices' => [
                'Manuelle' => 'manuelle',
                'Automatique' => 'automatique',
            ],
            'expanded' => false,  // Utilise un menu déroulant
            'multiple' => false,  // Un seul choix à la fois
        ])
        // Menu déroulant pour les marques existantes
        ->add('marque', EntityType::class, [
            'class' => Marque::class,
            'choice_label' => 'nomMarque',
            'placeholder' => 'Sélectionnez une marque existante',
            'required' => false,
        ])
        // Champ texte pour ajouter une nouvelle marque
        ->add('nouvelleMarque', TextType::class, [
            'required' => false,
            'mapped' => false, // Ce champ n'est pas lié à l'entité
            'label' => 'Ou ajoutez une nouvelle marque',
        ])
        // Menu déroulant pour les modèles existants
        ->add('modele', EntityType::class, [
            'class' => Modele::class,
            'choice_label' => 'nomModele',
            'placeholder' => 'Sélectionnez un modèle existant',
            'required' => false,
        ])
        // Champ texte pour ajouter un nouveau modèle
        ->add('nouveauModele', TextType::class, [
            'required' => false,
            'mapped' => false, // Ce champ n'est pas lié à l'entité
            'label' => 'Ou ajoutez un nouveau modèle',
        ])
        ->add('description', TextType::class)
        ->add('imageFiles', CollectionType::class, [
            'entry_type' => FileType::class,
            'entry_options' => [
                'label' => 'Ajouter une image',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez choisir une image valide (JPEG ou PNG).',
                    ]),
                ],
            ],
            'allow_add' => true,
            'by_reference' => false,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}