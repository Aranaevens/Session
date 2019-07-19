<?php

namespace App\Form;

use App\Entity\Modul;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModuleCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('module', EntityType::class, [
            'class' => Modul::class,
            'choice_label' => 'intitule',
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
