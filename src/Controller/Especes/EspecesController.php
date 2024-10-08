<?php

namespace App\Controller\Especes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;
use App\Repository\EspecesTableRepository;
use App\Controller\Especes\UpdateMontantAvant;
use App\Controller\Especes\UpdateMontantApres;
use App\Controller\Especes\UpdateRecette;
use App\Controller\Especes\UpdateCaisse;

class EspecesController extends AbstractController
{

    public function index(string $year, 
                            HomeTableRepository $homeTableRepository,
                            EspecesTableRepository $especesTableRepository,

                            ): Response
    {
        $app = 'ESPECES';
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];
        $especes_tbl = $year . '_especes_table';

        $db = $homeTableRepository->findOneBy(array('name' => $app));
        $especesTableRepository->set_table_name($especes_tbl);
        $especes = $especesTableRepository->findAll();

        $updateMontantAvant = new UpdateMontantAvant;
        $updateMontantApres = new UpdateMontantApres;
        $updateRecette = new UpdateRecette;
        $updateCaisse = new UpdateCaisse;

        for ($i=0; $i < count($especes); $i++) {

            $updateMontantAvant->update_montant_avant($especes_tbl, $especesTableRepository, $especes, $i);
            if ($i > 0) {
                $updateMontantApres->update_montant_apres($especes_tbl, $especesTableRepository, $especes, $i);
                $updateRecette->update_recette($especes_tbl, $especesTableRepository, $especes, $i);
            }
        }
        $especes = $especesTableRepository->findAll();
        $updateCaisse->update_caisse($especes_tbl, $especesTableRepository, $especes, $i);

        $selectlist = 'e.especes_id, ma.nom AS manifestation, ca.nom AS caisse, e.date,
                        e.nombre_50, e.montant_50, e.nombre_20, e.montant_20, 
                        e.nombre_10, e.montant_10, e.nombre_5, e.montant_5, 
                        e.nombre_2, e.montant_2, e.nombre_1, e.montant_1,
                        e.nombre_050, e.montant_050, e.nombre_020, e.montant_020, 
                        e.nombre_010, e.montant_010, e.montant, nombre_50_apres, e.montant_50_apres, 
                        e.nombre_20_apres, e.montant_20_apres, e.nombre_10_apres, e.montant_10_apres, 
                        e.nombre_5_apres, e.montant_5_apres, e.nombre_2_apres, e.montant_2_apres, 
                        e.nombre_1_apres, e.montant_1_apres, e.nombre_050_apres, e.montant_050_apres, 
                        e.nombre_020_apres, e.montant_020_apres, e.nombre_010_apres, e.montant_010_apres, 
                        e.montant_apres, e.cheques, e.dons, e.recette' ;
        
        $from_table = $especes_tbl . ' e';
        $join_table = [ 
            [$db_common . '.manifestation_table ma', 'e.manifestation_id', 'ma.manifestation_id'],
            [$db_common . '.caisse_table ca', 'e.caisse_id', 'ca.caisse_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " ORDER BY e.especes_id ASC";

        $especes = $especesTableRepository->send_sql_cmd($sql_cmd);

        $selectlist = 'ma.nom AS manifestation, ca.nom AS caisse, e.date, e.recette' ;
        
        $from_table = $especes_tbl . ' e';
        $join_table = [ 
            [$db_common . '.manifestation_table ma', 'e.manifestation_id', 'ma.manifestation_id'],
            [$db_common . '.caisse_table ca', 'e.caisse_id', 'ca.caisse_id'],
                    ];
        $sql_cmd = "SELECT " . $selectlist . 
                    " FROM " . $from_table . 
                    " JOIN " . $join_table[0][0] . " ON " .  $join_table[0][1] . " = " . $join_table[0][2] .
                    " JOIN " . $join_table[1][0] . " ON " .  $join_table[1][1] . " = " . $join_table[1][2] .
                    " ORDER BY e.especes_id ASC";

        $recettes = $especesTableRepository->send_sql_cmd($sql_cmd);
        // dd($recettes);
        $username = "";
        $role = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $role = ($this->getUser()->getRoles())[0];
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'EspecesController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_gallery' => true,
            'db' => $db->getName(),
            'especes' => $especes,
            'recettes' => $recettes,
            'year' => $year,
            'username' => $username,
            'role' => $role,        
        ]);
    }
}
