<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('intitule', TextType::class,[
            'required' => true,
            'label' => 'Intitulé de la catégorie',
            'attr' => 
                [
                    'class' => 'uk-input'
                ],
            'trim' => true,
            'constraints' => [
                new Length([
                    'min' => 3,
                    'minMessage' => 'L\intitulé doit fait au moins 3 caractères',
                    'max' => 99,
                    'maxMessage' => 'L\intitulé doit fait au plus 99 caractères'
                ])
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
            'data_class' => Categorie::class,
        ]);
    }
}
