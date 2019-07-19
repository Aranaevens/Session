<?php

namespace App\Form;

use App\Entity\Modul;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', TextType::class,[
                'required' => true,
                'label' => 'Intitulé du module',
                'attr' => [
                'class' => 'uk-input'
                ],
            ])
            ->add('categorie', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'intitule',
                'attr' => [
                    'class' => 'uk-select'
                    ],
            ])
            ->add('valider', SubmitType::class,[
                'attr'=>[
                    'class'=>'uk-button',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modul::class,
        ]);
    }
}
