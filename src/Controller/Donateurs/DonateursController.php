<?php

namespace App\Controller\Donateurs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Converter;
use App\Repository\ControllerTableRepository;
use App\Repository\CompteControllerTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\DonateursTableRepository;
use App\Repository\EspecesTableRepository;
use App\Repository\DonProjTableRepository;
use Symfony\Component\Validator\Constraints\DateTime;

class DonateursController extends AbstractController
{

    public function index(int $year, string $title,
                            ControllerTableRepository $controllerTableRepository,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            DonProjTableRepository $donprojTableRepository,
                            DonateursTableRepository $donateursTableRepository): Response
    {
        // DONATEURS
        $app = $title;
        $homepage = strtolower($title) . "_homepage";
        $controller_column_name = $this->getParameter('app.controller_column_name');

        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $donateursTableRepository->set_table_name($table_name);

        $donateurs = $donateursTableRepository->findAll();

        $cc_controller = $compteControllerTableRepository->findOneBy(criteria: [$controller_column_name => 'COMPTE']);
        $cc_table_name = $year . '_' . $cc_controller->getTbl();
        $courantTableRepository->set_table_name($cc_table_name);

        $cc_controller = $compteControllerTableRepository->findOneBy(criteria: [$controller_column_name => 'CAISSES']);
        $especes_table_name = $year . '_' . $cc_controller->getTbl();
        $especesTableRepository->set_table_name($especes_table_name);

        $col_donateur_id = "donateur_id";
        $dons_total = 0;
        for ($i=1; $i <  count($donateurs); $i++) {
            $donateurs[$i]->setMontant(0);

            // dd($default_date);
            $donateurs[$i]->setDDate(d_date: new \DateTime('2000-01-02'));
            $filter_cc_dons = $courantTableRepository->findBy([$col_donateur_id => $donateurs[$i]->getDonateurId()]);
            $filter_especes_dons = $especesTableRepository->findBy([$col_donateur_id => $donateurs[$i]->getDonateurId()]);

            if ($filter_cc_dons != []) {
                for ($j=0; $j < count($filter_cc_dons); $j++) {
                    $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $filter_cc_dons[$j]->getCredit());
                    $donateurs[$i]->setDDate($filter_cc_dons[$j]->getDate());
                }

            }
            if ($filter_especes_dons != []) {
                for ($j=0; $j < count($filter_especes_dons); $j++) {
                    $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $filter_especes_dons[$j]->getRecette());
                    $donateurs[$i]->setDDate($filter_especes_dons[$j]->getDate());
                }
            }
            $sql_cmd = 'UPDATE ' . $table_name . 
                        ' SET montant=' . $donateurs[$i]->getMontant() . 
                        ' WHERE donateur_id=' . $donateurs[$i]->getDonateurId() . ';';
            $donateursTableRepository->send_sql_update_cmd($sql_cmd);
            // dd($donateurs[$i]->getDDate());
            $sql_cmd = 'UPDATE ' . $table_name . 
                        ' SET d_date=CAST( "' . ($donateurs[$i]->getDDate())->format('Y-m-d') . '" AS DATE)' . 
                        ' WHERE donateur_id=' . $donateurs[$i]->getDonateurId() . ';';
            $donateursTableRepository->send_sql_update_cmd($sql_cmd);

            $dons_total += $donateurs[$i]->getMontant();
        }
        $donateurs = $donateursTableRepository->findAll();
        $sort = 'd_date';
        $sort_order = 'ASC';
        $donateurs = $donateursTableRepository->fetch_class_from_table_ordered($table_name,
                                                                                    $sort, $sort_order);
        $donprojs = [];
        if ($year == '2025') {
            $table_name = $year . '_' . 'donproj_table';
            $donprojTableRepository->set_table_name($table_name);
            $donprojs = $donprojTableRepository->findAll();

            $selectlist = 'dp.donateur_id, p1.projet AS p1_project, p1.affectation AS p1_affectation, 
                            p2.projet AS p2_project, p2.affectation AS p2_affectation' ;
            
            $from_table = $table_name . ' dp';
            $join_table = [ 
                            ['2025_project_table p1', 'dp.p1', 'p1.projet_id'],
                            ['2026_project_table p2', 'dp.p2', 'p2.projet_id'],
                        ];
            $sql_cmd = "SELECT " . $selectlist . 
                        " FROM " . $from_table . 
                        " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                        " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] 
                        ;

            $donprojs = $donprojTableRepository->send_sql_cmd($sql_cmd);
        }
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => $controller->getMetaIndex(),
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),
            'year' => $year,
            'homepage' => $homepage,
            
            'show_navbar' => true,
            'show_gallery' => true,

            'donateurs' => $donateurs,
            'dons_total' => $dons_total,
            'donprojs' => $donprojs,
        ]);
    }
}
