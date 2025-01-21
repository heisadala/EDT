<?php

namespace App\Controller\Update;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ControllerTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\CompteControllerTableRepository;
use App\Repository\ProjectControllerTableRepository;
use App\Repository\ProjectTableRepository;
use App\Repository\EspecesTableRepository;
use App\Repository\DonateursTableRepository;
use App\Repository\EdtTableRepository;
use App\Repository\BilanTableRepository;
use App\Controller\HelloAssoApi;

class UpdateController extends AbstractController
{
    private function set_repo_tbl_name($year, $name, $ctrlrepo, $tblrepo) {

        $controller = $ctrlrepo->findOneBy(['name' => $name]);
        $table_name = $year . '_' . $controller->getTbl();
        $tblrepo->set_table_name($table_name);
        return $table_name;
    }


    public function index (string $title, 
                            ControllerTableRepository $controllerTableRepository,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            EdtTableRepository $edtTableRepository,
                            BilanTableRepository $bilanTableRepository,
                            ProjectControllerTableRepository $projectControllerTableRepository,
                            DonateursTableRepository $donateursTableRepository,
                            ProjectTableRepository $projectTableRepository): Response
    {
        $year = $this->getParameter('app.year');
        for ($app_year=$year; $app_year < $year+2; $app_year++) {
        // $app_year = 2025;

            $compte_table_name = $this->set_repo_tbl_name($app_year, 'COMPTE', $compteControllerTableRepository, $courantTableRepository);
            $project_table_name = $this->set_repo_tbl_name($app_year, 'PROJECT', $projectControllerTableRepository, $projectTableRepository);
            $especes_table_name = $this->set_repo_tbl_name($app_year, 'CAISSES', $compteControllerTableRepository, $especesTableRepository);
            $edt_table_name = $this->set_repo_tbl_name($app_year, 'EDT', $compteControllerTableRepository, $edtTableRepository);
            $donateur_table_name = $this->set_repo_tbl_name($app_year, 'DONATEURS', $controllerTableRepository, $donateursTableRepository);
            $bilan_table_name = $this->set_repo_tbl_name($app_year, 'BILAN', $compteControllerTableRepository, $bilanTableRepository);

            // UPDATE CASH TABLE


            // UPDATE PROJECT TABLE FROM ACCOUNT TABLE - F MONTANT AND CASH TABLE C MONTANT
            $projets = $projectTableRepository->findAll();
            for ($i=1; $i < count($projets); $i++) {
                $projets[$i]->setFMontant(0);
                $projets[$i]->setCMontant(0);
                $f_montant = 0;
                $c_montant = 0;
                $compte_proj = $courantTableRepository->findBy(['projet_id' => $projets[$i]->getProjetId()]);
                if ($compte_proj != []) {
                    for ($j=0; $j < count($compte_proj); $j++) {
                        $f_montant = $f_montant + $compte_proj[$j]->getDebit() - $compte_proj[$j]->getCredit();
                    }
                    $projets[$i]->setFMontant($f_montant);
                }
                $especes_proj = $especesTableRepository->findBy(['projet_id' => $projets[$i]->getProjetId()]);
                if ($especes_proj != []) {
                    for ($j=0; $j < count($especes_proj); $j++) {
                        $c_montant = $c_montant + $especes_proj[$j]->getMontant() - $especes_proj[$j]->getMontantApres();

                    }
                    $projets[$i]->setCMontant($c_montant);
                }
                $column_value = 'f_montant=' . $projets[$i]->getFMontant()
                . ', c_montant=' . $projets[$i]->getCMontant()
                . ', montant=' . $projets[$i]->getCMontant() + $projets[$i]->getFMontant()
                ;
                $sql_cmd = 'UPDATE ' . $project_table_name . ' SET ' . $column_value . ' WHERE projet_id=' . $projets[$i]->getProjetId() . ';';
                $projectTableRepository->send_sql_update_cmd($sql_cmd);
            }

            // UPDATE DONATEURS TABLE FROM ACCOUNT TABLE AND CASH TABLE - MONTANT
            $donateurs = $donateursTableRepository->findAll();
            for ($i=1; $i < count($donateurs); $i++) {
                $donateurs[$i]->setMontant(0);
                $compte_don = $courantTableRepository->findBy(['donateur_id' => $donateurs[$i]->getDonateurId()]);
                if ($compte_don != []) {
                    for ($j=0; $j < count($compte_don); $j++) {
                        $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $compte_don[$j]->getCredit());
                    }
                }
                $especes_don = $especesTableRepository->findBy(['donateur_id' => $donateurs[$i]->getDonateurId()]);
                if ($especes_don != []) {
                    for ($j=0; $j < count($especes_don); $j++) {
                        $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $especes_don[$j]->getRecette());
                    }
                }
                $column_value = 'montant=' . $donateurs[$i]->getMontant();
                $sql_cmd = 'UPDATE ' . $donateur_table_name . ' SET ' . $column_value . ' WHERE donateur_id=' . $donateurs[$i]->getDonateurId() . ';';
                $donateursTableRepository->send_sql_update_cmd($sql_cmd);
            }

            // UPDATE EDT TABLE FROM ACCOUNT TABLE AND CASH TABLE - MONTANT
            // if ($app_year == 2025) dd($edt);
            $edt = $edtTableRepository->findAll();


            // if ($app_year == 2025) dd($edt);
            for ($i=1; $i < count($edt); $i++) {
                $edt[$i]->setDebit(0);;
                $edt[$i]->setCredit(0);
                $edt[$i]->setCMontant(0);
                $edt[$i]->setMontant(0);
            
                $compte_edt = $courantTableRepository->findBy(['edt_id' => $edt[$i]->getEdtId()]);
                // if ($i == 3) dd($edt[$i]->getEdtId());
                if ($compte_edt != []) {
                    for ($j=0; $j < count($compte_edt); $j++) {
                        $edt[$i]->setCredit($edt[$i]->getCredit() + $compte_edt[$j]->getCredit());
                        $edt[$i]->setDebit($edt[$i]->getDebit() + $compte_edt[$j]->getDebit());
                    }
                }
                $especes_edt = $especesTableRepository->findBy(['edt_id' => $edt[$i]->getEdtId()]);
                if ($especes_edt != []) {
                    for ($j=0; $j < count($especes_edt); $j++) {
                        $edt[$i]->setCMontant($edt[$i]->getCMontant()
                                + $especes_edt[$j]->getRecette()
                                );
                    }
                }
                $edt[$i]->setMontant($edt[$i]->getDebit() - $edt[$i]->getCredit() - $edt[$i]->getCMontant());

                $column_value = 'credit=' . $edt[$i]->getCredit()
                . ', debit=' . $edt[$i]->getDebit()
                . ', c_montant=' . $edt[$i]->getCMontant()
                . ', montant=' . $edt[$i]->getMontant()
                ;
                $sql_cmd = 'UPDATE ' . $edt_table_name . ' SET ' . $column_value . ' WHERE edt_id=' . $edt[$i]->getEdtId() . ';';
                $edtTableRepository->send_sql_update_cmd($sql_cmd);
            }
            if ($app_year == 2025) {
                $column_value = 'montant=-140' ;
                $sql_cmd = "UPDATE " . $edt_table_name . " SET montant=-140 WHERE edt_id=7;" ;
                $edtTableRepository->send_sql_update_cmd($sql_cmd);
            }

            // if ($app_year == 2025) dd( $edtTableRepository);
            // BILAN DONS
            $don = 0;
            $don_associations = 0;
            $don_particuliers = 0;
            $don_entreprises = 0;
            $don_ecoles = 0;
            $donateurs = $donateursTableRepository->findAll();
            for ($i=1; $i < count($donateurs); $i++) {
                $don += $donateurs[$i]->getMontant();
                if ($donateurs[$i]->getTypeId() == 1) {
                    $don_associations += $donateurs[$i]->getMontant();
                }
                if ($donateurs[$i]->getTypeId() == 2) {
                    $don_particuliers += $donateurs[$i]->getMontant();
                }
                if ($donateurs[$i]->getTypeId() == 3) {
                    $don_entreprises += $donateurs[$i]->getMontant();
                }
                if ($donateurs[$i]->getTypeId() == 10) {
                    $don_ecoles += $donateurs[$i]->getMontant();
                }
            }
            $column_value = 'don=' . $don
                            . ', don_associations=' . $don_associations
                            . ', don_particuliers=' . $don_particuliers
                            . ', don_ecoles=' . $don_ecoles
                            . ', don_entreprises=' . $don_entreprises
                            ;
            $sql_cmd = 'UPDATE ' . $bilan_table_name . ' SET ' . $column_value . ' WHERE bilan_id=1;';
            $bilanTableRepository->send_sql_update_cmd($sql_cmd);

            // BILAN ADHESIONS
            $sql_cmd = "SELECT * FROM " . $edt_table_name . " WHERE affectation='EDT_ADHESIONS_" . $app_year . "';";
            $adherants = $edtTableRepository->send_sql_cmd($sql_cmd);
            $montant = $adherants[0]['montant'] * (-1);
            $column_value = 'adhesions=' . $montant;
            $sql_cmd = 'UPDATE ' . $bilan_table_name . ' SET ' . $column_value . ' WHERE bilan_id=1;';
            $bilanTableRepository->send_sql_update_cmd($sql_cmd);

            // BILAN MANIFESTATIONS
            $r_manifestations = 0;
            $r_handifference = 0;
            $r_trail_estran = 0;
            $r_rando_nature = 0;
            $r_marche_noel = 0;
            $d_manifestations = 0;
            $d_handifference = 0;
            $d_trail_estran = 0;
            $d_rando_nature = 0;
            $d_marche_noel = 0;
            $edt = $edtTableRepository->findAll();
    // if ($app_year == 2025) dd( $edt);
            for ($i=1; $i < count($edt); $i++) {
                if ($edt[$i]->getAffectation() == 'EDT_HANDIFFERENCE') {
                    $r_handifference += $edt[$i]->getCredit() + $edt[$i]->getCMontant();
                    $d_handifference += $edt[$i]->getDebit();
                }
                if ($edt[$i]->getAffectation() == 'EDT_RANDO_NATURE') {
                    $r_rando_nature += $edt[$i]->getCredit() + $edt[$i]->getCMontant();
                    $d_rando_nature += $edt[$i]->getDebit();
                }
                if ($edt[$i]->getAffectation() == 'EDT_TRAIL_ESTRAN') {
                    $r_trail_estran += $edt[$i]->getCredit() + $edt[$i]->getCMontant();
                    $d_trail_estran += $edt[$i]->getDebit();
                }
                if (str_contains($edt[$i]->getAffectation(), 'EDT_MARCHE_NOEL')){
                    $r_marche_noel += $edt[$i]->getCredit() + $edt[$i]->getCMontant();
                    $d_marche_noel += $edt[$i]->getDebit();
                }
            }
            $r_manifestations += $r_handifference + $r_rando_nature + $r_trail_estran + $r_marche_noel;
            $d_manifestations += $d_handifference + $d_rando_nature + $d_trail_estran + $d_marche_noel;

            $column_value = 'r_manifestations=' . $r_manifestations
                            . ', r_handifference=' . $r_handifference
                            . ', r_rando_nature=' . $r_rando_nature
                            . ', r_trail_estran=' . $r_trail_estran
                            . ', r_marche_noel=' . $r_marche_noel
                            . ', d_manifestations=' . $d_manifestations
                            . ', d_handifference=' . $d_handifference
                            . ', d_rando_nature=' . $d_rando_nature
                            . ', d_trail_estran=' . $d_trail_estran
                            . ', d_marche_noel=' . $d_marche_noel
                            ;
            $sql_cmd = 'UPDATE ' . $bilan_table_name . ' SET ' . $column_value . ' WHERE bilan_id=1;';
            $bilanTableRepository->send_sql_update_cmd($sql_cmd);

            // BILAN FONCTIONNEMENT
            $fonctionnement = 0;
            $fournitures = 0;
            $assurance = 0;
            $divers = 0;
            $r_banque = 0;
            $d_banque = 0;
            for ($i=1; $i < count($edt); $i++) {
                if ($edt[$i]->getAffectation() == 'EDT_FONCTIONNEMENT_FOURNITURE') {
                    $fournitures += $edt[$i]->getMontant();
                }
                if ($edt[$i]->getAffectation() == 'EDT_FONCTIONNEMENT_ASSURANCE') {
                    $assurance += $edt[$i]->getMontant();
                }
                if ($edt[$i]->getAffectation() == 'EDT_FONCTIONNEMENT_DIVERS') {
                    $divers += $edt[$i]->getMontant();
                }
                if ($edt[$i]->getAffectation() == 'EDT_FONCTIONNEMENT_BANQUE') {
                    $r_banque += $edt[$i]->getCredit();
                    $d_banque += $edt[$i]->getDebit();
                }
            }
            $fonctionnement = $fournitures + $assurance + $divers;

            $column_value = 'fonctionnement=' . $fonctionnement
                            . ', fournitures=' . $fournitures
                            . ', assurance=' . $assurance
                            . ', r_banque=' . $r_banque
                            . ', d_banque=' . $d_banque
                            ;
            $sql_cmd = 'UPDATE ' . $bilan_table_name . ' SET ' . $column_value . ' WHERE bilan_id=1;';
            $bilanTableRepository->send_sql_update_cmd($sql_cmd);

            // BILAN PROJETS
            $projets = 0;
            $hdj = 0;
            $camsp = 0;
            $trestel = 0;
            $estran = 0;
            $hds = 0;
            $je = 0;
            $sesad = 0;
            $ue = 0;
            $projects = $projectTableRepository->findAll();
            for ($i=1; $i < count($projects); $i++) {
                $projets += $projects[$i]->getMontant();
                if ($projects[$i]->getAffectation() == 'HDJ') {
                    $hdj += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'CAMSP') {
                    $camsp += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'TRESTEL') {
                    $trestel += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'ESTRAN') {
                    $estran += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'HDS') {
                    $hds += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'JE') {
                    $je += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'SESAD') {
                    $sesad += $projects[$i]->getMontant();
                }
                if ($projects[$i]->getAffectation() == 'UE') {
                    $ue += $projects[$i]->getMontant();
                }
            }
            $column_value = 'projets=' . $projets
                            . ', hdj=' . $hdj
                            . ', camsp=' . $camsp
                            . ', trestel=' . $trestel
                            . ', estran=' . $estran
                            . ', hds=' . $hds
                            . ', je=' . $je
                            . ', sesad=' . $sesad
                            . ', ue=' . $ue
                            ;
            $sql_cmd = 'UPDATE ' . $bilan_table_name . ' SET ' . $column_value . ' WHERE bilan_id=1;';
            $bilanTableRepository->send_sql_update_cmd($sql_cmd);

            }
            
            // HOME
            $app = $title;
            $controller = $controllerTableRepository->findOneBy(['name' => $app]);

            $project_controller = $projectControllerTableRepository->findOneBy(['name' => 'PROJECT']);

            $project_table_name = $year . '_' . $project_controller->getTbl();
            $projectTableRepository->set_table_name($project_table_name);
            $affectation_list_1 = $projectTableRepository->get_affectation_list($project_table_name);

            $project_table_name = $year+1 . '_' . $project_controller->getTbl();
            $projectTableRepository->set_table_name($project_table_name);
            $affectation_list_2 = $projectTableRepository->get_affectation_list($project_table_name);

            $helloAssoApi = new HelloAssoApi;
            $resp = $helloAssoApi->getToken();
            $obj = json_decode($resp, true);
            $resp = $helloAssoApi->getPaiementsInfo($obj['access_token']);
            // echo $resp;
            $obj = json_decode($resp, true);
            // dd( $obj['data']);
            $counter = 0;
            for ($i=0; $i < count($obj['data']); $i++){
                for ($j=0; $j < count($obj['data'][$i]['items']); $j++) {
                    if ($obj['data'][$i]['items'][$j]['type'] == 'Registration') {
                        $counter = $counter + 1;
                    }
                }
            }
    
            $username = "";
            $role = "";
            if ($this->getUser()) {
                $username = $this->getUser()->getUsername();
                $role = ($this->getUser()->getRoles())[0];
            }
            if ($_SERVER['BASE'] == '') { $_SERVER['BASE'] = '/EDT/public';}

            return $this->render('index.html.twig', [
                'controller_name' => $title . 'Controller',
                'server_base' => $_SERVER['BASE'],
                'meta_index' => 'index',
                'header_title' => $controller->getHeaderTitle(),
                'shortcut_icon' => $controller->getIcon(),
                'db' => $controller->getName(),
                'bg_color' => $controller->getBgColor(),
                
                'show_navbar' => true,
                'show_cards' => true,
                'username' => $username,
                'role' => $role,
                'affectation_1' => $affectation_list_1,
                'affectation_2' => $affectation_list_2,
                'participants' => $counter
            ]);
    }
}
