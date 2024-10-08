<?php

namespace App\Controller\Project;

use App\Repository\EspecesTableRepository;
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

    public function index(string $year,string $etatFilter, 
                            HomeTableRepository $homeTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EtatTableRepository $etatTableRepository
                        ): Response
    {
        $app = 'PROJECT';
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $db = $homeTableRepository->findOneBy(['name' => $app]);
        $table_name = $year . '_' . $db->getTbl();
        $projectTableRepository->set_table_name($table_name);

        $projets =$projectTableRepository->findAll();

        $compte_table_name = $year . '_' . 'compte_cheques_table';
        $courantTableRepository->set_table_name($compte_table_name);
        $account =$courantTableRepository->findAll();

        $especes_table_name = $year . '_' . 'especes_table';
        $especesTableRepository->set_table_name($especes_table_name);
        $caisse =$especesTableRepository->findOneBy(['especes_id' => '0']);

        $etat_table_name = $db_common . '.etat_table';
        $etatTableRepository->set_table_name($etat_table_name);
        $etats =$etatTableRepository->findAll();
        $sql_cmd = "SELECT structure FROM $table_name WHERE structure != 'EDT' GROUP BY structure ORDER by structure ASC;";
        $structure = $projectTableRepository->send_sql_cmd($sql_cmd);

        for ($i=1; $i <  count($projets); $i++) {
            $projets[$i]->setFMontant(0);

            $compte_proj = $courantTableRepository->select_all_from_where($compte_table_name, 'projet_id', $projets[$i]->getProjetId());
            if ($compte_proj != []) {
                for ($j=0; $j < count($compte_proj); $j++) {
                    $projets[$i]->setFMontant($projets[$i]->getFMontant() + $compte_proj[$j]['debit']);
                    $projets[$i]->setFMontant($projets[$i]->getFMontant() - $compte_proj[$j]['credit']);
                }

            }
            $especes_proj = $especesTableRepository->select_all_from_where($especes_table_name, 'projet_id', $projets[$i]->getProjetId());
            if ($especes_proj != []) {
                for ($j=0; $j < count($especes_proj); $j++) {
                    if ($especes_proj[$j]['recette'] < 0) {
                        $projets[$i]->setFMontant($projets[$i]->getFMontant()
                            + $especes_proj[$j]['montant']
                            - $especes_proj[$j]['montant_apres']
                            );
                        }
                    }

            }
            $projectTableRepository->update_f_montant( $table_name, 
                                                        'f_montant', 
                                                        $projets[$i]->getFMontant(),  
                                                        $projets[$i]->getProjetId()
                                                    );
        
        }
        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.structure, pr.name, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.f_montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = $table_name . ' p';
        $join_table = [ 
                        [$db_common . '.prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        [$db_common . '.etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " ORDER BY p.projet_id ASC";

        $projets = $projectTableRepository->send_sql_cmd($sql_cmd);

        $new_sql_cmd = 'SELECT etat, etat_id, bg_color, text_color, count(etat) AS count FROM (' . $sql_cmd . " ) a 
                        GROUP BY etat ORDER by etat_id ASC;";
        $etats = $projectTableRepository->send_sql_cmd($new_sql_cmd);
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
            'role' => $role,       
            'structure' => $structure,
            'year' => $year,        
            'caisse' => $caisse,        
        ]);
    }



    public function structure(string $year, string $structureFilter, string $etatFilter, 
                            HomeTableRepository $homeTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EtatTableRepository $etatTableRepository
                        ): Response
    {
        $app = 'STRUCTURE';
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];
        $db = $homeTableRepository->findOneBy(['name' => $app]);
        $table_name = $year . '_' . $db->getTbl();
        $projectTableRepository->set_table_name($table_name);

        $projets =$projectTableRepository->findBy(['structure' => $structureFilter]);

        $compte_table_name = $year . '_' . 'compte_cheques_table';
        $courantTableRepository->set_table_name($compte_table_name);
        $account =$courantTableRepository->findBy(['affectation' => $structureFilter]);

        $especes_table_name = $year . '_' . 'especes_table';

        $etat_table_name = $db_common . '.etat_table';
        $etatTableRepository->set_table_name($etat_table_name);
        $etats =$etatTableRepository->findAll();
        $sql_cmd = "SELECT structure FROM $table_name WHERE structure != 'EDT' GROUP BY structure ORDER by structure ASC;";
        $structure = $projectTableRepository->send_sql_cmd($sql_cmd);

        for ($i=0; $i <  count($projets); $i++) {
            $projets[$i]->setFMontant(0);

            $filter_proj = $courantTableRepository->select_all_from_where($compte_table_name, 'projet_id', $projets[$i]->getProjetId());

            if ($filter_proj != []) {
                for ($j=0; $j < count($filter_proj); $j++) {
                    $projets[$i]->setFMontant($projets[$i]->getFMontant() + $filter_proj[$j]['debit']);
                    $projets[$i]->setFMontant($projets[$i]->getFMontant() - $filter_proj[$j]['credit']);
                }

            }
            $especes_proj = $especesTableRepository->select_all_from_where($especes_table_name, 'projet_id', $projets[$i]->getProjetId());
            if ($especes_proj != []) {
                for ($j=0; $j < count($especes_proj); $j++) {
                    if ($especes_proj[$j]['recette'] < 0) {
                        $projets[$i]->setFMontant($projets[$i]->getFMontant()
                            + $especes_proj[$j]['montant']
                            - $especes_proj[$j]['montant_apres']
                            );
                        }
                    }

            }            
            $projectTableRepository->update_f_montant( $table_name,
                                                        'f_montant', 
                                                        $projets[$i]->getFMontant(),  
                                                        $projets[$i]->getProjetId()
                                                    );
        
        }
        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.structure, pr.name, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.f_montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = $table_name . ' p';
        $join_table = [ 
                        [$db_common . '.prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        [$db_common . '.etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " WHERE p.structure = '" . $structureFilter . "' ORDER BY p.projet_id ASC";

        $projets = $projectTableRepository->send_sql_cmd($sql_cmd);

        $new_sql_cmd = 'SELECT etat, etat_id, bg_color, text_color, count(etat) AS count FROM (' . $sql_cmd . " ) a 
                        GROUP BY etat ORDER by etat_id ASC;";
        $etats = $projectTableRepository->send_sql_cmd($new_sql_cmd);
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
            'structureFilter' => $structureFilter,
            'etatFilter' => $etatFilter,
            'username' => $username,
            'role' => $role,        
            'structure' => $structure, 
            'year' => $year,        
        ]);
    }

    public function public_projects(string $year,string $etatFilter, 
                            HomeTableRepository $homeTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EtatTableRepository $etatTableRepository
                        ): Response
    {
        $app = 'PUBLIC_PROJECTS';
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];
        $db = $homeTableRepository->findOneBy(['name' => $app]);
        $table_name = $year . '_' . $db->getTbl();
        $projectTableRepository->set_table_name($table_name);

        // $projets =$projectTableRepository->findAll();
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
        }
        $unknown_projets_total = 0;
        for ($i=0; $i <  count($unknown_projets); $i++) {
            $unknown_projets_total += $unknown_projets[$i]->getFMontant();
        }
        $ongoing_projets_total = 0;
        for ($i=0; $i <  count($ongoing_projets); $i++) {
            $ongoing_projets_total += $ongoing_projets[$i]->getFMontant();
        }
        $foreseen_projets_total = 0;
        for ($i=0; $i <  count($foreseen_projets); $i++) {
            $foreseen_projets_total += $foreseen_projets[$i]->getDMontant();
        }



        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.structure, pr.name, pr.url, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.f_montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = $table_name . ' p';
        $join_table = [ 
                        [$db_common . '.prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        [$db_common . '.etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " ORDER BY p.projet_id ASC";

        $projets = $projectTableRepository->send_sql_cmd($sql_cmd);

        $new_sql_cmd = 'SELECT etat, etat_id, bg_color, text_color, count(etat) AS count FROM (' . $sql_cmd . " ) a 
                        GROUP BY etat ORDER by etat_id ASC;";
        $etats = $projectTableRepository->send_sql_cmd($new_sql_cmd);
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
            'db' => $db->getName(),
            'projets' => $projets,
            'etats' => $etats,
            'etatFilter' => $etatFilter,
            'username' => $username,
            'role' => $role,       
            'year' => $year,        
            'closed_projets_total' => $closed_projets_total,
            'nb_closed_projets' => $nb_closed_projets,        
            'unknown_projets_total' => $unknown_projets_total,
            'nb_unknown_projets' => $nb_unknown_projets,        
            'ongoing_projets_total' => $ongoing_projets_total,
            'nb_ongoing_projets' => $nb_ongoing_projets,        
            'foreseen_projets_total' => $foreseen_projets_total,
            'nb_foreseen_projets' => $nb_foreseen_projets,              ]);
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
