<?php

namespace App\Controller\Ag;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AgController extends AbstractController
{
    public function index(string $subject): Response
    {
        $show_carousel_ag = true;
        $show_carousel_photo = false;
        if ($subject == 'AG') {
            $show_carousel_ag = true;
            $show_carousel_photo = false;
        }
        else {
            $show_carousel_ag = false;
            $show_carousel_photo = true;
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'AgController',
            'server_base' => $_SERVER['BASE'],
            'title' => 'AG',
            'icon' => 'Edt.png',
            'db' => 'AG',
            'show_navbar' => false,
            'show_carousel_ag' => $show_carousel_ag,
            'show_carousel_photo' => $show_carousel_photo,
            'show_flyer' => false,
        ]);
    }
}
