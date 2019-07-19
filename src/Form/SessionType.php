<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule',TextType::class,[
                'required' => true,
                'label' => 'Intitulé de formation',
                'attr' => [
                'class' => 'uk-input'
                ],
            ])
            ->add('nbPlaces',NumberType::class,[
                'required' => true,
                'label'=> 'Nombre de places',
                'attr'=>[
                'class'=>'uk-input'
                ],
            ])
            ->add('dateDebut',DateType::class,[
                'required' => true,
                'widget' => 'simple_text',
                'label' => 'Date de debut',
                'attr'=>[
                    'class'=>'uk-input'
                ],
            ])
            ->add('dateFin',DateType::class,[
                'required' => true,
                'widget' => 'simple_text',
                'label' => 'Date de fin',
                'attr'=>[
                    'class'=>'uk-input'
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
            'data_class' => Session::class,
        ]);
    }
}
