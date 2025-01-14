<?php

namespace App\Controller\Project;

use App\Repository\EspecesTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ControllerTableRepository;
use App\Repository\ProjectControllerTableRepository;
use App\Repository\CompteControllerTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\ProjectTableRepository;
use App\Repository\EtatTableRepository;
use App\Repository\YearTableRepository;
use App\Repository\EdtTableRepository;

class ProjectController extends AbstractController
{

    function set_repo_tbl_name($year, $name, $ctrlrepo, $tblrepo) {

        $controller = $ctrlrepo->findOneBy(['name' => $name]);
        $table_name = $year . '_' . $controller->getTbl();
        $tblrepo->set_table_name($table_name);
        return $table_name;
    }

    public function index(int $year, string $etatFilter, string $title,
                            ProjectControllerTableRepository $projectControllerTableRepository,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EtatTableRepository $etatTableRepository
                        ): Response
    {
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];
        $controller = $projectControllerTableRepository->findOneBy(criteria: ['name' => $title]);

        $project_table_name = $this->set_repo_tbl_name($year, $title, $projectControllerTableRepository, $projectTableRepository);
        $projets =$projectTableRepository->findAll();

        $compte_table_name = $this->set_repo_tbl_name($year, 'COMPTE', $compteControllerTableRepository, $courantTableRepository);
        $account =$courantTableRepository->findAll();

        $etat_table_name = $db_common . '.etat_table';
        $etatTableRepository->set_table_name($etat_table_name);

        $sql_cmd = "SELECT affectation, count(affectation) AS count FROM $project_table_name GROUP BY affectation ORDER by affectation ASC;";
        $affectation = $projectTableRepository->send_sql_cmd($sql_cmd);

        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.affectation, pr.name, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = $project_table_name . ' p';
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
        // dd($affectations);
        $username = "";
        $role = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $role = ($this->getUser()->getRoles())[0];
        }
        $show_dashboard = false;
        $show_gallery = true;
        
        return $this->render('index.html.twig', [
            'controller_name' => ucfirst($title) . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_gallery' => $show_gallery,
            'projets' => $projets,
            'account' => $account,
            'etats' => $etats,
            'etatFilter' => $etatFilter,
            'username' => $username,
            'role' => $role,       
            'affectation' => $affectation,
            'year' => $year,        
        ]);
    }



    public function affectation(int $year, string $structureFilter, string $etatFilter, string $title,
                            ProjectControllerTableRepository $projectControllerTableRepository,
                            ControllerTableRepository $controllerTableRepository,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EtatTableRepository $etatTableRepository
                        ): Response
    {
        $app = $title;
        $controller = $projectControllerTableRepository->findOneBy(criteria: ['name' => $app]);

        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $table_name = $year . '_' . $controller->getTbl();
        $projectTableRepository->set_table_name($table_name);

        $projets =$projectTableRepository->findBy(['affectation' => $structureFilter]);

        $cc_controller = $compteControllerTableRepository->findOneBy(criteria: ['name' => 'COMPTE']);
        $compte_table_name = $year . '_' .  $cc_controller->getTbl();
        $courantTableRepository->set_table_name($compte_table_name);

        $account =$courantTableRepository->findBy(['affectation' => $structureFilter]);


        $etat_table_name = $db_common . '.etat_table';
        $etatTableRepository->set_table_name($etat_table_name);
        $etats =$etatTableRepository->findAll();
        $sql_cmd = "SELECT affectation, count(affectation) AS count FROM $table_name WHERE affectation != 'EDT' GROUP BY affectation ORDER by affectation ASC;";
        $affectation = $projectTableRepository->send_sql_cmd($sql_cmd);

        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.affectation, pr.name, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.montant, p_e.bg_color, p_e.text_color' ;
        
        $from_table = $table_name . ' p';
        $join_table = [ 
                        [$db_common . '.prestataire_table pr', 'p.prestataire_id', 'pr.prestataire_id'],
                        [$db_common . '.etat_table p_e', 'p.etat_id', 'p_e.etat_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " WHERE p.affectation = '" . $structureFilter . "' ORDER BY p.projet_id ASC";

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

        
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_gallery' => $show_gallery,
            'projets' => $projets,
            'account' => $account,
            'etats' => $etats,
            'structureFilter' => $structureFilter,
            'etatFilter' => $etatFilter,
            'username' => $username,
            'role' => $role,        
            'affectation' => $affectation, 
            'year' => $year,        
        ]);
    }

    
    public function dashboard(int $year, string $title,
                            ProjectControllerTableRepository $projectControllerTableRepository,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ProjectTableRepository $projectTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EdtTableRepository $edtTableRepository,
                            EtatTableRepository $etatTableRepository,
                            YearTableRepository $yearTableRepository
                        ): Response
    {
        $app = $title;
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];
        $db_app = $_SERVER['DATABASE_APP_NAME'];

        $controller = $projectControllerTableRepository->findOneBy(criteria: ['name' => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $projectTableRepository->set_table_name($table_name);

        $projets =$projectTableRepository->findAll();

        $cc_controller = $compteControllerTableRepository->findOneBy(criteria: ['name' => 'COMPTE']);
        $compte_table_name = $year . '_' .  $cc_controller->getTbl();
        $courantTableRepository->set_table_name($compte_table_name);

        $account =$courantTableRepository->findAll();

        $year_table = $yearTableRepository->findOneBy(['year_id' => $year]);

        $credit = 0;
        $debit = 0;
        $livret_interets_2024 = 828.65;
        $total = $year_table->getCc_begin();
        $total_livret = $year_table->getLivret_begin();
        for ($i=0; $i < count($account); $i++) {
            $credit += $account[$i]->getCredit();
            $debit += $account[$i]->getDebit();
            // INTERN = 4
            if ($account[$i]->getAffectationId() ==  4 ) {
                $total_livret -= $account[$i]->getCredit();
                $total_livret += $account[$i]->getDebit();
            }
        }
        $total += $credit - $debit;

        if ($year == '2024') {
            $total_livret += $livret_interets_2024;
            $yearTableRepository->update($db_app . '.year_table', 'cc_now', $total, 'year_id', '2024' );
            $yearTableRepository->update($db_app . '.year_table', 'livret_now', $total_livret, 'year_id', '2024' );
            $yearTableRepository->update($db_app . '.year_table', 'cc_begin', $total, 'year_id', '2025' );
            $yearTableRepository->update($db_app . '.year_table', 'livret_begin', $total_livret, 'year_id', '2025' );
        }
        if ($year == '2025') {
            $yearTableRepository->update($db_app . '.year_table', 'cc_now', $total, 'year_id', '2025' );
            $yearTableRepository->update($db_app . '.year_table', 'livret_now', $total_livret, 'year_id', '2025' );
        }
        $especes_table_name = $year . '_' . 'especes_table';
        $especesTableRepository->set_table_name($especes_table_name);

        $caisse = $especesTableRepository->findOneBy(['especes_id' => '0']);

        $sql_cmd = "SELECT * FROM $especes_table_name WHERE donateur_id != 0 ORDER by donateur_id ASC;";
        $caisse_don = $especesTableRepository->send_sql_cmd($sql_cmd);

        $edt_table_name = $year . '_' . 'edt_table';
        $edtTableRepository->set_table_name($edt_table_name);
        $caisse_edt = $edtTableRepository->findAll();



        $etat_table_name = $db_common . '.etat_table';
        $etatTableRepository->set_table_name($etat_table_name);
        $etats =$etatTableRepository->findAll();

        $sql_cmd = "SELECT affectation FROM $table_name WHERE affectation != 'EDT' GROUP BY affectation ORDER by affectation ASC;";
        $affectation = $projectTableRepository->send_sql_cmd($sql_cmd);


        $selectlist = 'p.projet_id, p.etat_id, p_e.etat, p.projet, p.affectation, pr.name, pr.mail, p.d_date, 
        p.f_date, p.p_recu, p.p_sig, p.d_recu, p.d_sig, p.d_montant, 
        p.montant, p_e.bg_color, p_e.text_color' ;
        
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
        $title = ucfirst(strtolower($app));
            $show_dashboard = true;
            $title = "Bilan";           
        
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_dashboard' => $show_dashboard,
            'projets' => $projets,
            'account' => $account,
            'etats' => $etats,
            'username' => $username,
            'role' => $role,       
            'affectation' => $affectation,
            'year' => $year,        
            'caisse' => $caisse,        
            'caisse_don' => $caisse_don,        
            'caisse_edt' => $caisse_edt,        
            'year_table' => $year_table,        
        ]);
    }

function toto() {

            $selectlist = 'c.compte_id, c_e.etat AS c_etat, c.date, c.debit, c.credit, c.facture, c.operation, 
            p.projet_id, p_e.etat AS p_etat, p.projet, p.affectation, pr.name, pr.mail, p.d_date, 
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
