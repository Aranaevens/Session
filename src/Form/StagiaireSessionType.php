<?php

namespace App\Form;

use App\Entity\Modul;
use App\Entity\Session;
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
                'attr' => [
                    'class' => 'uk-select'
                ],
            ])
            ->add('back', SubmitType::class, [
                'label' => 'Ajouter et revenir',
                'attr' => [
                    'class' => 'uk-button'
                ],
            ])
            ->add('comeback', SubmitType::class, [
                'label' => 'Ajouter puis ajouter un autre',
                'attr' => [
                    'class' => 'uk-button'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //
        ]);
    }
}
