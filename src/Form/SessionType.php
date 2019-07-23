<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
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
            ->add('nbPlaces',NumberType::class,[
                'required' => true,
                'label'=> 'Nombre de places',
                'attr'=>[
                    'class'=>'uk-input'
                ],
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le nombre de jours ne peut pas être négatif',
                    ])
                ],
            ])
            ->add('dateDebut',DateType::class,[
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de debut',
                'attr'=>[
                    'class'=>'uk-input'
                ],
            ])
            ->add('dateFin',DateType::class,[
                'required' => true,
                'widget' => 'single_text',
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
