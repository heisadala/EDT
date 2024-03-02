<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'server_base' => $_SERVER['BASE'],
            'title' => 'Accueil',
            'icon' => 'Edt.png',
            'news' => 'ASSEMBLÉE GÉNÉRALE AU CAFÉ LA DIFFÉRENCE LE 15 MARS 2024 À 18H30 SALLE POLYVALENTE DE TRÉLÉVERN',
            'header_image' => 'Trestel_2.jpg',

        ]);
    }
}
