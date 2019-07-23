<?php

namespace App\Form;

use App\Entity\Modul;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ModuleSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('module', EntityType::class, [
                'class' => Modul::class,
                'choice_label' => 'intitule',
                'attr' => [
                    'class' => 'uk-select'
                ],
                'required' => true
            ])
            ->add('nbjours', IntegerType::class, [
                'label' => 'Durée du module dans la formation',
                'attr' => [
                    'class' => 'uk-input'
                ],
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le nombre de jours ne peut pas être négatif',
                    ])
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
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
