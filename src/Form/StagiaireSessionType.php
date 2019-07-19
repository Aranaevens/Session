<?php

namespace App\Form;

use App\Entity\Modul;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StagiaireSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stagiaire', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => function (Stagiaire $stag) {
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
