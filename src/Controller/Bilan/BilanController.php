<?php

namespace App\Controller\Bilan;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BilanTableRepository;
use App\Repository\CompteControllerTableRepository;


class BilanController extends AbstractController
{
    public function index(int $year, string $title,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            BilanTableRepository $bilanTableRepository,
                        ): Response
    {
        
        $controller = $compteControllerTableRepository->findOneBy(criteria: ['name' => $title]);
        $bilan_table_name = $year . '_' . 'bilan_table';
        $bilanTableRepository->set_table_name($bilan_table_name);
        $bilan = $bilanTableRepository->findAll();

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_table' => true,
            'bilan' => $bilan,
            'year' => $year,        
   
        ]);
    }


}
