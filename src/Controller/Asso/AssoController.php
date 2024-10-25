<?php

namespace App\Controller\Asso;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ControllerTableRepository;

class AssoController extends AbstractController
{
    public function index(string $title,
                            ControllerTableRepository $controllerTableRepository): Response
    {
        $app = $title;
        $controller = $controllerTableRepository->findOneBy(['name' => $app]);

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            
            'navbar_title' => $controller->getNavbarTitle(),
            'show_navbar' => true,
            'show_cards' => true,
        ]);
    }
}
