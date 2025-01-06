<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AdminAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Repository\HomeTableRepository;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, 
                                UserPasswordHasherInterface $userPasswordHasher, 
                                UserAuthenticatorInterface $userAuthenticator, 
                                // AdminAuthenticator $authenticator, 
                                EntityManagerInterface $entityManager,
                                HomeTableRepository $homeTableRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $table_name = $this->getParameter('app.database_home_table_name');
        $db = $homeTableRepository->findOneby(['name' => $table_name]);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('homepage');

        }

        return $this->render('index.html.twig', [
            'controller_name' => 'RegistrationController',
            'header_title' => 'Register EDT user',
            'show_register' => true,
            'shortcut_icon' => $db->getIcon(),
            'meta_index' => 'noindex',
            'news' => '',
            'db' => "registration",
            'server_base' => $_SERVER['BASE'],
            'registrationForm' => $form->createView(),
            'show_navbar' => true,

                ]);
    }
}
