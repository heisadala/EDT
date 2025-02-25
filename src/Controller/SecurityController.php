<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\ControllerTableRepository;

class SecurityController extends AbstractController
{
    public function login(string $title,
                            AuthenticationUtils $authenticationUtils,
                            ControllerTableRepository $controllerTableRepository): Response
    {
        // dd ($this->getUser());
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }
        $app = $title;
        $controller = $controllerTableRepository->findOneBy(['name' => $app]);

        $username = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => false,
            'show_login' => true,

            'last_username' => $lastUsername, 
            'error' => $error,
            'username' => $username,

        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
