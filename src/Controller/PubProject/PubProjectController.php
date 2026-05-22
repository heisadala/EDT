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
        $app_years = $this->getParameter('app.years');
        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $projectTableRepository->set_table_name($table_name);


        $closed_projets =$projectTableRepository->findBy(['etat_id' => '1']);
        $nb_closed_projets = count($closed_projets);
        $unknown_projets =$projectTableRepository->findBy(['etat_id' => '4']);
        $nb_unknown_projets = count($unknown_projets);

        $nb_realized = $nb_closed_projets + $nb_unknown_projets ;

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

        $m_total = $closed_projets_total + $unknown_projets_total;

        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.affectation, d.nom, pr.name, pr.url, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.montant, p_e.bg_color, p_e.text_color, t.cat_class, t.cat_icon' ;
        
        $from_table = $table_name . ' p';
        $join_table = [ 
                        [$year . '_donateurs_table d', 'p.donateur_id', 'd.donateur_id'],
                        [$db_common . '.prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        [$db_common . '.etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                        [$db_common . '.projet_type_table t', 'p.type_id', 't.type_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " JOIN " . $join_table[2][0] . " ON " .  $join_table[2][1] . " = " . $join_table[2][2] .
                    " JOIN " . $join_table[3][0] . " ON " .  $join_table[3][1] . " = " . $join_table[3][2] .
                    "  WHERE p.etat_id IN (1,4) ORDER BY p.projet_id ASC";

        // pas de fiche et cloturé
        $projets = $projectTableRepository->send_sql_cmd($sql_cmd);
        // dd($projets);


        $view_table_name = $year . "_project_view";
        $sql_cmd = "SELECT structure, count(structure) AS count, color FROM $view_table_name WHERE etat IN ('clôturé','pas de fiche') GROUP BY structure ORDER by structure ASC;";
        $structures = $projectTableRepository->send_sql_cmd($sql_cmd);
        // dd($structures);

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
            
            'app_years' => $app_years,

            'show_public_navbar' => true,
            'show_hero' => true,
            'show_gallery' => true,

            'projets' => $projets,
            'structures' => $structures,
            'year' => $year,
         
            'nb_realized' => $nb_realized,
            'm_total' => $m_total,

        ]);
    }


}
