<?php

namespace App\Controller\Christmas;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ControllerTableRepository;

class ChristmasController extends AbstractController
{
    public function index (int $year, string $title,
                            ControllerTableRepository $controllerTableRepository): Response
    {
        $app = $title;
        $homepage = strtolower($title) . "_homepage";
        $controller = $controllerTableRepository->findOneBy(['name' => $app]);

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),
            'homepage' => $homepage,
            
            'navbar_title' => $controller->getNavbarTitle(),
            'year' => $year,
            'show_navbar' => true,
            'show_cards' => true,
        ]);
    }
}
