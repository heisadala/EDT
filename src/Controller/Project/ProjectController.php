<?php

namespace App\Controller\Project;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\ProjectTableRepository;
use App\Repository\PrestataireTableRepository;
use App\Repository\EtatTableRepository;

class ProjectController extends AbstractController
{

    public function index(string $etatFilter, 
                            HomeTableRepository $homeTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            PrestataireTableRepository $prestataireTableRepository,
                            EtatTableRepository $etatTableRepository
                        ): Response
    {
        $app = 'PROJECT';
        $db = $homeTableRepository->findOneBy(['name' => $app]);

        $projets =$projectTableRepository->findAll();
        $account =$courantTableRepository->findAll();
        $etats =$etatTableRepository->findAll();

        for ($i=1; $i <  count($projets); $i++) {
            $projets[$i]->setFMontant(0);

            $filter_proj = $courantTableRepository->select_all_from_where('projet_id', $projets[$i]->getProjetId());

            if ($filter_proj != []) {
                for ($j=0; $j < count($filter_proj); $j++) {
                    $projets[$i]->setFMontant($projets[$i]->getFMontant() + $filter_proj[$j]['debit']);
                    $projets[$i]->setFMontant($projets[$i]->getFMontant() - $filter_proj[$j]['credit']);
                }

            }
            $projectTableRepository->update_f_montant( 'f_montant', 
                                                        $projets[$i]->getFMontant(),  
                                                        $projets[$i]->getProjetId()
                                                    );
        
        }
        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.structure, pr.name, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.f_montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = 'project_table p';
        $join_table = [ 
                        ['prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        ['etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " ORDER BY p.projet_id ASC";

        $projets = $courantTableRepository->send_sql_cmd($sql_cmd);

        $new_sql_cmd = 'SELECT etat, etat_id, bg_color, text_color, count(etat) AS count FROM (' . $sql_cmd . " ) a 
                        GROUP BY etat ORDER by etat_id ASC;";
        $etats = $courantTableRepository->send_sql_cmd($new_sql_cmd);
        //dd($etats);
        $username = "";
        $role = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $role = ($this->getUser()->getRoles())[0];
        }
        $show_dashboard = false;
        $show_gallery = true;
        $title = ucfirst(strtolower($app));
        if ($etatFilter == 'DASH') {
            $show_dashboard = true;
            $show_gallery = false;
            $title = "Bilan";           
        }
        
        return $this->render('index.html.twig', [
            'controller_name' => 'ProjectController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'title' => $title,
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_gallery' => $show_gallery,
            'show_dashboard' => $show_dashboard,
            'db' => $db->getName(),
            'projets' => $projets,
            'account' => $account,
            'etats' => $etats,
            'etatFilter' => $etatFilter,
            'username' => $username,
            'role' => $role,        ]);
    }

function toto() {

            $selectlist = 'c.compte_id, c_e.etat AS c_etat, c.date, c.debit, c.credit, c.facture, c.operation, 
            p.projet_id, p_e.etat AS p_etat, p.projet, p.structure, pr.name, pr.mail, p.d_date, 
            p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
            p.f_montant, c.affectation, p_e.bg_color' ;

            $from_table = 'compte_cheques_table c';
            $join_table = [ 
                    ['project_table p', 'c.projet_id', 'p.projet_id'],
                    ['prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                    ['etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ['etat_table c_e', 'c.etat_id', 'c_e.etat_id'],
                ];
            $sql_cmd = "SELECT " . $selectlist . 
                " FROM " . $from_table . 
                " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                " JOIN " . $join_table[2][0] . " ON " .  $join_table[2][1] . " = " . $join_table[2][2] .
                " JOIN " . $join_table[3][0] . " ON " .  $join_table[3][1] . " = " . $join_table[3][2] .
                " ORDER BY c.date ASC";

            // dd($sql_cmd);
            //$account = $courantTableRepository->send_sql_cmd($sql_cmd);
}}