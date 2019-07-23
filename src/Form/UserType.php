<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Adresse e-mail',
                'trim' => true,
                'attr' => [
                    'class' => 'uk-input'
                ],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'L\email doit contenir au moins 6 caractères',
                        'max' => 99,
                        'maxMessage' => 'L\email doit contenir au plus 99 caractères'
                    ])
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'required' => true,
                'mapped' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'attr' => [
                    'class' => 'uk-input'
                ],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins 3 caractères',
                        'max' => 32,
                        'maxMessage' => 'Le mot de passe doit contenir au plus 32 caractères'
                    ])
                ],
            ])
            ->add('role', ChoiceType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Ajouter un rôle',
                'choices' => ['Utilisateur' => 'ROLE_USER', 'Administrateur' => 'ROLE_ADMIN']]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
