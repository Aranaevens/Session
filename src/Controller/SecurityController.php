<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/user/add", name="user_add")
     */
    public function addUser(User $user = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if (!$user)
        {
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user)
                        ->add('Valider', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function editUser(User $user, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($user != $this->getUser())
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        $form = $this->createForm(UserType::class, $user);
        if ($this->isGranted('ROLE_ADMIN'))
        {
            $form->add('role', ChoiceType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Ajouter un rôle',
                'choices' => ['Utilisateur' => 'ROLE_USER', 'Administrateur' => 'ROLE_ADMIN']]);          
        }
        $form->add('Valider', SubmitType::class, [
            'attr' => [
                'class' => 'uk-button'
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
            if ($this->isGranted('ROLE_ADMIN'))
            {
                $user->setRoles(array($form->get('role')->getData()));
            }
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
