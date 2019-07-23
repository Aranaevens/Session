<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',TextType::class, [
            'required' => true,
            'label' => 'Nom',
            'attr' => [
                'class' => 'uk-input'
            ],
            'trim' => true,
            'constraints' => [
                new Length([
                    'min' => 3,
                    'minMessage' => 'Le nom doit contenir au moins 3 caractères',
                    'max' => 99,
                    'maxMessage' => 'Le nom doit contenir au plus 99 caractères'
                ])
            ],
        ])
        ->add('prenom',TextType::class, [
            'required' => true,
            'label' => 'Prénom',
            'attr' => [
                'class' => 'uk-input'
            ],
            'trim' => true,
            'constraints' => [
                new Length([
                    'min' => 3,
                    'minMessage' => 'Le prénom doit contenir au moins 3 caractères',
                    'max' => 99,
                    'maxMessage' => 'Le prénom doit contenir au plus 99 caractères'
                ])
            ],
        ])
        ->add('genre',ChoiceType::class, [
            'required' => true,
            'label' => 'Genre',
            'choices' => ['Homme' => 'M', 'Femme' => 'F'],
            'expanded' => true,
            'multiple' => false,
            
        ])
        ->add('datenaissance',DateType::class, [
            'required' => true,
            'widget' => 'single_text',
            'label' => 'Date de naissance',
            'attr' => [
                'class' => 'uk-input'
            ],
        ])
        ->add('ville',TextType::class, [
            'required' => true,
            'label' => 'Ville',
            'attr' => [
                'class' => 'uk-input'
            ],
            'trim' => true,
            'constraints' => [
                new Length([
                    'min' => 3,
                    'minMessage' => 'Le nom de la ville doit contenir au moins 3 caractères',
                    'max' => 75,
                    'maxMessage' => 'Le nom de la ville doit contenir au plus 75 caractères'
                ])
            ],
        ])
        ->add('email', EmailType::class, [
            'required' => true,
            'label' => 'Adresse e-mail',
            'attr' => [
                'class' => 'uk-input'
            ],
            'trim' => true,
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'L\email doit contenir au moins 6 caractères',
                    'max' => 99,
                    'maxMessage' => 'L\email doit contenir au plus 99 caractères'
                ])
            ],
        ])
        ->add('telephone', TelType::class, [
            'required' => true,
            'label' => 'Numéro de Téléphone',
            'attr' => [
                'class' => 'uk-input uk-form-small uk-form-width-medium'
            ],
            'trim' => true,
            'constraints' => [
                new Length([
                    // Solomon Island have the shortest with country code 677 + 5 digits.
                    'min' => 8,
                    'minMessage' => 'Le numéro de téléphone doit contenir au moins 8 caractères',
                    // The E.164 recommandation defines 15 digits as the maximum for international phone numbering.
                    'max' => 15,
                    'maxMessage' => 'Le numéro de téléphone doit contenir au plus 15 caractères'
                ])
            ],
        ])
        ->add('Valider', SubmitType::class, [
            'attr' => [
                'class' => 'uk-button'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formateur::class,
        ]);
    }
}
