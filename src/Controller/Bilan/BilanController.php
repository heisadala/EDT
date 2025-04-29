<?php

namespace App\Controller\Bilan;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BilanTableRepository;
use App\Repository\ControllerTableRepository;
use App\Repository\CompteControllerTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\EspecesTableRepository;
use App\Repository\ProjectTableRepository;
use App\Repository\DonateursTableRepository;
use App\Repository\EdtTableRepository;


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
        $username = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
        }

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
            'username' => $username,
   
        ]);
    }

    private function get_year_table_from_account($table_name, $id){
        $sql_cmd = "SELECT YEAR(`date`) AS year, SUM(`debit`) AS debit, SUM(`credit`) AS credit 
            FROM $table_name 
            WHERE $id<>0 
            GROUP BY YEAR(`date`);";
        return $sql_cmd;     
    }

        private function get_month_table_from_account($table_name, $id){
        $sql_cmd = "SELECT YEAR(`date`) AS year, MONTH(`date`) AS month, SUM(`debit`) AS debit, SUM(`credit`) AS credit 
            FROM $table_name 
            WHERE $id<>0 
            GROUP BY YEAR(`date`), MONTH(`date`);";
        return $sql_cmd;     
    }

    private function get_day_table_from_account($table_name, $id){
        $sql_cmd = "SELECT YEAR(`date`) AS year, MONTH(`date`) AS month, DAY(`date`) AS day, SUM(`debit`) AS debit, SUM(`credit`) AS credit 
            FROM $table_name 
            WHERE $id<>0 
            GROUP BY YEAR(`date`), MONTH(`date`), DAY(`date`);";
        return $sql_cmd;     
    }

    private function get_day_table_from_especes($table_name, $id){
        $sql_cmd = "SELECT YEAR(`date`) AS year, MONTH(`date`) AS month, DAY(`date`) AS day, SUM(`recette`) AS credit, cheques AS debit 
            FROM $table_name 
            WHERE $id<>0 
            GROUP BY YEAR(`date`), MONTH(`date`), DAY(`date`);";
        return $sql_cmd;     
    }
    private function get_day_table_from_project($table_name, $id){
        $sql_cmd = "SELECT YEAR(`p_recu`) AS year, MONTH(`p_recu`) AS month, DAY(`p_recu`) AS day, SUM(`d_montant`) AS devis 
            FROM $table_name 
            WHERE $id<>0 
            GROUP BY YEAR(`p_recu`), MONTH(`p_recu`), DAY(`p_recu`);";
        return $sql_cmd;     
    }
    public function evolution (int $year, string $title,
                                ControllerTableRepository $controllerTableRepository,
                                CompteChequesTableRepository $courantTableRepository,
                                EspecesTableRepository $especesTableRepository,

                                ProjectTableRepository $projectTableRepository,
                                EdtTableRepository $edtTableRepository,
                                DonateursTableRepository $donateursTableRepository
                            ): Response
{
        
        $app = $title;
        $year= 2025;

        $controller = $controllerTableRepository->findOneBy(criteria: ['name' => $app]);

        $courant_table_name = $year . '_' . 'compte_cheques_table';
        $courantTableRepository->set_table_name($courant_table_name);
        // $account = $courantTableRepository->findAll();

        $sql_cmd = $this->get_day_table_from_account($courant_table_name, 'projet_id');
        $projets_account = $courantTableRepository->send_sql_cmd($sql_cmd);
        $sql_cmd = $this->get_day_table_from_account($courant_table_name, 'donateur_id');
        $donateurs_account = $courantTableRepository->send_sql_cmd($sql_cmd);
        $sql_cmd = $this->get_day_table_from_account($courant_table_name, 'edt_id');
        $edt_account = $courantTableRepository->send_sql_cmd($sql_cmd);
        // dd($donateurs_account);

        $especes_table_name = $year . '_' . 'especes_table';
        $especesTableRepository->set_table_name($especes_table_name);
        // $especes = $especesTableRepository->findAll();

        $sql_cmd = $this->get_day_table_from_especes($especes_table_name, 'projet_id');
        $projets_especes = $especesTableRepository->send_sql_cmd($sql_cmd);

        //dd($projets_especes);

        for ($i=0; $i<count($projets_especes); $i++){
            if ($projets_especes[$i]['credit'] < 0) {
                $projets_especes[$i]['debit'] = -($projets_especes[$i]['credit']);
                $projets_especes[$i]['credit'] = 0;
            }
        } 
        // dd($projets_especes);
        $sql_cmd = $this->get_day_table_from_especes($especes_table_name, 'donateur_id');
        $donateurs_especes = $especesTableRepository->send_sql_cmd($sql_cmd);
        // dd($donateurs_especes);
        $sql_cmd = $this->get_day_table_from_especes($especes_table_name, 'edt_id');
        $edt_especes = $especesTableRepository->send_sql_cmd($sql_cmd);

        //dd($projets_especes);

        for ($i=0; $i<count($edt_especes); $i++){
            if ($edt_especes[$i]['credit'] < 0) {
                $edt_especes[$i]['debit'] = -($projets_especes[$i]['credit']);
                $edt_especes[$i]['credit'] = 0;
            } else {
                $edt_especes[$i]['debit'] = 0;
            }
        } 

        $project_table_name = $year . '_' . 'project_table';
        $projectTableRepository->set_table_name($project_table_name);
        $sql_cmd = $this->get_day_table_from_project($project_table_name, 'affectation_id');
        $projets_devis = $projectTableRepository->send_sql_cmd($sql_cmd);

        $projets = array_merge($projets_account, $projets_especes);
        $donateurs = array_merge($donateurs_account, $donateurs_especes);
        $edts = array_merge($edt_account, $edt_especes);
        // dd($projets);
        // dd($donateurs);
        // dd($edts);
        // dd($projets_devis);




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
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_chart' => true,

            'username' => $username,
            'role' => $role,       

//            'account' => $account,
            'projets' => $projets,
            'edts' => $edts,        
            'donateurs' => $donateurs,
            'projets_devis' => $projets_devis,

            'year' => $year

        ]);
    }

}
