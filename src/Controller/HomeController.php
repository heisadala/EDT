<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;

class HomeController extends AbstractController
{
    public function index(HomeTableRepository $homeTableRepository): Response
    {

        $app = $this->getParameter('app.application_name');
        $table_name = $this->getParameter('app.database_home_table_name');

        $db = $homeTableRepository->findOneby(['name' => $table_name]);

        $username = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'server_base' => $_SERVER['BASE'],
            'title' => 'Accueil' . $app,
            'icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_cards' => true,
            'db' => $db->getName(),
            'username' => $username,
        ]);
    }
}
