<?php

namespace App\Controller\PubProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ControllerTableRepository;
use App\Repository\ProjectTableRepository;

class PubProjectController extends AbstractController
{

    public function index(int $year, string $title, 
                            ControllerTableRepository $controllerTableRepository,
                            ProjectTableRepository $projectTableRepository,
                        ): Response
    {
        // PUBLIC_PROJETS
        $app = $title;
        $homepage = strtolower($title) . "_homepage";
        $controller_column_name = $this->getParameter('app.controller_column_name');

        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $projectTableRepository->set_table_name($table_name);

        $closed_projets =$projectTableRepository->findBy(['etat_id' => '1']);
        $nb_closed_projets = count($closed_projets);
        $unknown_projets =$projectTableRepository->findBy(['etat_id' => '4']);
        $nb_unknown_projets = count($unknown_projets);
        $ongoing_projets =$projectTableRepository->findBy(['etat_id' => '2']);
        $nb_ongoing_projets = count($ongoing_projets);
        $foreseen_projets =$projectTableRepository->findBy(['etat_id' => '9']);
        $nb_foreseen_projets = count($foreseen_projets);

        $closed_projets_total = 0;
        for ($i=0; $i <  count($closed_projets); $i++) {
            $closed_projets_total += $closed_projets[$i]->getFMontant();
            $closed_projets_total += $closed_projets[$i]->getCMontant();
        }
        $unknown_projets_total = 0;
        for ($i=0; $i <  count($unknown_projets); $i++) {
            $unknown_projets_total += $unknown_projets[$i]->getFMontant();
            $unknown_projets_total += $unknown_projets[$i]->getCMontant();
        }
        $ongoing_projets_total = 0;
        for ($i=0; $i <  count($ongoing_projets); $i++) {
            $ongoing_projets_total += $ongoing_projets[$i]->getFMontant();
            $ongoing_projets_total += $ongoing_projets[$i]->getCMontant();
        }
        $foreseen_projets_total = 0;
        for ($i=0; $i <  count($foreseen_projets); $i++) {
            $foreseen_projets_total += $foreseen_projets[$i]->getDMontant();
        }

        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.affectation, d.nom, pr.name, pr.url, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = $table_name . ' p';
        $join_table = [ 
                        [$year . '_donateurs_table d', 'p.donateur_id', 'd.donateur_id'],
                        [$db_common . '.prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        [$db_common . '.etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " JOIN " . $join_table[2][0] . " ON " .  $join_table[2][1] . " = " . $join_table[2][2] .
                    " ORDER BY p.projet_id ASC";

        $projets = $projectTableRepository->send_sql_cmd($sql_cmd);

        $new_sql_cmd = 'SELECT etat, etat_id, bg_color, text_color, count(etat) AS count FROM (' . $sql_cmd . " ) a 
                        GROUP BY etat ORDER by etat_id ASC;";
        $etats = $projectTableRepository->send_sql_cmd($new_sql_cmd);
        
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),
            'homepage' => $homepage,

            'show_navbar' => true,
            'show_gallery' => true,

            'projets' => $projets,
            'etats' => $etats,
            'year' => $year,        
            'closed_projets_total' => $closed_projets_total,
            'nb_closed_projets' => $nb_closed_projets,        
            'unknown_projets_total' => $unknown_projets_total,
            'nb_unknown_projets' => $nb_unknown_projets,        
            'ongoing_projets_total' => $ongoing_projets_total,
            'nb_ongoing_projets' => $nb_ongoing_projets,        
            'foreseen_projets_total' => $foreseen_projets_total,
            'nb_foreseen_projets' => $nb_foreseen_projets,
        ]);
    }


}
