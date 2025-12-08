<?php

namespace App\Controller\Noel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ControllerTableRepository;
use App\Repository\MarcheNoelTableRepository;
final class NoelController extends AbstractController
{
    public function index(int $year, string $title, 
                            ControllerTableRepository $controllerTableRepository,
                            MarcheNoelTableRepository $marcheNoelTableRepository,
                        ): Response
    {
        // PUBLIC_PROJETS
        $app = $title;

        $controller_column_name = $this->getParameter('app.controller_column_name');

        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $marcheNoelTableRepository->set_table_name($table_name);

 
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $selectlist = 'e.nom, e.artisanat, e.fb, e.insta, e.url, e.img, e.img2025, e.nouveau, m.table' ;
        
        $from_table = $table_name . ' m';
        $join_table = [ 
                        [$db_common . '.exposant_table e', 'm.exposant_id', 'e.exposant_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " ORDER BY e.nom ASC";

        $exposants = $marcheNoelTableRepository->send_sql_cmd($sql_cmd);
    
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_gallery' => true,

            'exposants' => $exposants,
            'year' => $year,        

/* 
            'etats' => $etats,
            'closed_projets_total' => $closed_projets_total,
            'nb_closed_projets' => $nb_closed_projets,        
            'unknown_projets_total' => $unknown_projets_total,
            'nb_unknown_projets' => $nb_unknown_projets,        
            'ongoing_projets_total' => $ongoing_projets_total,
            'nb_ongoing_projets' => $nb_ongoing_projets,        
            'foreseen_projets_total' => $foreseen_projets_total,
            'nb_foreseen_projets' => $nb_foreseen_projets,
 */        ]);
    }

    public function trestel(int $year, string $title, 
                            ControllerTableRepository $controllerTableRepository,
                            MarcheNoelTableRepository $marcheNoelTableRepository,
                        ): Response
    {
        // PUBLIC_PROJETS
        $app = $title;

        $controller_column_name = $this->getParameter('app.controller_column_name');

        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $marcheNoelTableRepository->set_table_name($table_name);

 
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $selectlist = 'e.nom, e.artisanat, e.fb, e.insta, e.url, e.img, e.img2025, e.nouveau, m.table' ;
        
        $from_table = $table_name . ' m';
        $join_table = [ 
                        [$db_common . '.exposant_table e', 'm.exposant_id', 'e.exposant_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " ORDER BY e.nom ASC";

        $exposants = $marcheNoelTableRepository->send_sql_cmd($sql_cmd);
    
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_gallery' => true,

            'exposants' => $exposants,
            'year' => $year,        

/* 
            'etats' => $etats,
            'closed_projets_total' => $closed_projets_total,
            'nb_closed_projets' => $nb_closed_projets,        
            'unknown_projets_total' => $unknown_projets_total,
            'nb_unknown_projets' => $nb_unknown_projets,        
            'ongoing_projets_total' => $ongoing_projets_total,
            'nb_ongoing_projets' => $nb_ongoing_projets,        
            'foreseen_projets_total' => $foreseen_projets_total,
            'nb_foreseen_projets' => $nb_foreseen_projets,
 */        ]);
    }


}
