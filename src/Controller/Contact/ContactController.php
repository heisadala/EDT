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
        $app = 'CONTACT';
        
        $db = $homeTableRepository->findOneBy(array('name' => $app));

        return $this->render('index.html.twig', [
            'controller_name' => 'ContactController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_cards' => true,
            'db' => $db->getName(),
        ]);
    }
}
