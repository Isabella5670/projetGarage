<?php

// src/Form/ModeleType.php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\Marque;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomModele', TextType::class)
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'nomMarque',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modele::class,
        ]);
    }
}