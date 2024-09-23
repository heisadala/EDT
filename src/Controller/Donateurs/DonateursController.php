<?php

namespace App\Controller\Donateurs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;
use App\Repository\DonateursTableRepository;
use App\Entity\DonateursTable;
use App\Service\Converter;
use App\Repository\CompteChequesTableRepository;
use App\Repository\AffectationTableRepository;

class DonateursController extends AbstractController
{

    function toObject($Array) {
        // Create new stdClass object
        $object = new DonateursTable();
        
        // Use loop to convert array into
        // stdClass object
        foreach ($Array as $key => $value) {
 
            $object->$key = $value;
        }
        return $object;
    }

    public function index(string $year, 
                            HomeTableRepository $homeTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            AffectationTableRepository $affectationTableRepository,
                            DonateursTableRepository $donateursTableRepository): Response
    {
        $app = 'DONATEURS';
        $donateur_tbl = $year . '_donateurs_table';

        $account_col_donateur_id = "donateur_id";

        $db = $homeTableRepository->findOneBy(array('name' => $app));
        $donateursTableRepository->set_table_name($donateur_tbl);
        $donateurs = $donateursTableRepository->findAll();
        $dons_total = 0;
        for ($i=1; $i <  count($donateurs); $i++) {
            $donateurs[$i]->setMontant(0);
            $filter_dons = $courantTableRepository->findBy([$account_col_donateur_id => $donateurs[$i]->getDonateurId()]);

            if ($filter_dons != []) {
                for ($j=0; $j < count($filter_dons); $j++) {
                    $donateurs[$i]->setMontant($donateurs[$i]->getMontant() + $filter_dons[$j]->getCredit());
                }

            }
            $donateursTableRepository->update( $donateur_tbl, 'montant', 
                                                $donateurs[$i]->getMontant() ,  
                                                'donateur_id',
                                                $donateurs[$i]->getDonateurId()
                                            );
            $dons_total += $donateurs[$i]->getMontant();
        }

        $donateurs = $donateursTableRepository->findAll();

        return $this->render('index.html.twig', [
            'controller_name' => 'ContactController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_gallery' => true,
            'db' => $db->getName(),
            'donateurs' => $donateurs,
            'year' => $year,
            'dons_total' => $dons_total,
        ]);
    }
}
