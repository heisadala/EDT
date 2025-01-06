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
        $app = $title;
        $controller = $controllerTableRepository->findOneBy(['name' => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $donateursTableRepository->set_table_name($table_name);

        $donateurs = $donateursTableRepository->findAll();

        $cc_controller = $compteControllerTableRepository->findOneBy(criteria: ['name' => 'COMPTE']);
        $cc_table_name = $year . '_' . $cc_controller->getTbl();
        $courantTableRepository->set_table_name($cc_table_name);

        $cc_controller = $compteControllerTableRepository->findOneBy(criteria: ['name' => 'CAISSES']);
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
            $donateursTableRepository->update( $table_name, 'montant', 
                                                $donateurs[$i]->getMontant() ,  
                                                'donateur_id',
                                                $donateurs[$i]->getDonateurId()
                                            );
            $dons_total += $donateurs[$i]->getMontant();
        }

        $donateurs = $donateursTableRepository->findAll();

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'navbar_title' => $controller->getNavbarTitle(),
            'show_navbar' => true,
            'show_gallery' => true,
            'donateurs' => $donateurs,
            'year' => $year,
            'dons_total' => $dons_total,
        ]);
    }
}
