<?php

namespace App\Form;

use App\Entity\Modul;
use App\Entity\Composer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ComposerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
        ->add('nbjours', IntegerType::class, [
            'label' => 'Durée du module dans la formation',
            'attr' => [
                'class' => 'uk-input'
            ],
        ])
        ->add('modifier', SubmitType::class, [
            'label' => 'Ajouter et revenir',
            'attr' => [
                'class' => 'uk-button'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Composer::class,
        ]);
    }
}
