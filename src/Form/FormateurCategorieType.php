<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormateurCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('formateur', EntityType::class, [
            'class' => Formateur::class,
            'choice_label' => function (Formateur $stag) {
                return $stag->getPrenom() . " " . $stag->getNom();
            },
            'multiple' => true,
            'expanded' => true,
        ])
        ->add('ajouter', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'uk-button'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
