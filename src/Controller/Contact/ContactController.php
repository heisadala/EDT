<?php

namespace App\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;

class ContactController extends AbstractController
{
    public function index(HomeTableRepository $homeTableRepository): Response
    {
        $db = $homeTableRepository->findOneBy(array('name' => 'CONTACT'));
        // $table_name = $this->getParameter('CONTACT');
        // $db = $homeTableRepository->findOneby(['name' => $table_name]);

        return $this->render('index.html.twig', [
            'controller_name' => 'ContactController',
            'server_base' => $_SERVER['BASE'],
            'title' => 'Contact',
            'icon' => 'Edt.png',
            'news' => '',
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_cards' => true,
            'db' => $db->getName(),
        ]);
    }
}