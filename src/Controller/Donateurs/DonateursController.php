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

class DonateursController extends AbstractController
{

    public function index(int $year, string $title,
                            ControllerTableRepository $controllerTableRepository,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            EspecesTableRepository $especesTableRepository,
                            DonateursTableRepository $donateursTableRepository): Response
    {
        // DONATEURS
        $app = $title;
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
            $filter_cc_dons = $courantTableRepository->findBy([$col_donateur_id => $donateurs[$i]->getDonateurId()]);
            $filter_especes_dons = $especesTableRepository->findBy([$col_donateur_id => $donateurs[$i]->getDonateurId()]);

            if ($filter_cc_dons != []) {
                for ($j=0; $j < count($filter_cc_dons); $j++) {
                    $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $filter_cc_dons[$j]->getCredit());
                }

            }
            if ($filter_especes_dons != []) {
                for ($j=0; $j < count($filter_especes_dons); $j++) {
                    $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $filter_especes_dons[$j]->getRecette());
                }

            }
            $sql_cmd = 'UPDATE ' . $table_name . 
                        ' SET montant=' . $donateurs[$i]->getMontant() . 
                        ' WHERE donateur_id=' . $donateurs[$i]->getDonateurId() . ';';
            $donateursTableRepository->send_sql_update_cmd($sql_cmd);

            $dons_total += $donateurs[$i]->getMontant();
        }
        $donateurs = $donateursTableRepository->findAll();

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

            'show_navbar' => true,
            'show_gallery' => true,

            'donateurs' => $donateurs,
            'dons_total' => $dons_total,
        ]);
    }
}
