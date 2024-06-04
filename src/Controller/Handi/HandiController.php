<?php

namespace App\Controller\Handi;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;

class HandiController extends AbstractController
{
    public function index(HomeTableRepository $homeTableRepository): Response
    {

        $app = 'HANDI';

        $db = $homeTableRepository->findOneBy(array('name' => $app));
        $username = "";

        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'title' => 'Accueil ' . $app,
            'icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_cards' => true,
            'db' => $db->getName(),
        ]);
    }}
