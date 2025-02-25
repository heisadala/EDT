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
        // ASSO
        $app = $title;
        $controller_column_name = $this->getParameter('app.controller_column_name');
        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => $controller->getMetaIndex(),
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),
            
            'show_navbar' => true,
            'show_cards' => true,
        ]);
    }
}
