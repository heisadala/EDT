<?php

namespace App\Controller\Asso;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;

class AssoController extends AbstractController
{
    public function index(HomeTableRepository $homeTableRepository): Response
    {
        $app = 'ASSO';

        $db = $homeTableRepository->findOneBy(array('name' => $app));

        return $this->render('index.html.twig', [
            'controller_name' => 'AssoController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_flyer' => true,
            'db' => $db->getName(),
                ]);
    }
}
