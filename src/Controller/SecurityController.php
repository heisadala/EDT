<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\HomeTableRepository;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,
                            HomeTableRepository $homeTableRepository): Response
    {
        // dd ($this->getUser());
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $table_name = $this->getParameter('app.database_home_table_name');
        $db = $homeTableRepository->findOneby(['name' => $table_name]);
        $username = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('index.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'controller_name' => 'SecurityController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => 'Login',
            'shortcut_icon' => 'Edt.png',
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => false,
            'show_login' => true,
            'db' => $db->getName(),
            'username' => $username,


        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
