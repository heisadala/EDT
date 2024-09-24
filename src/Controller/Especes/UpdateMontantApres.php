<?php
namespace App\Controller\Especes;


class UpdateMontantApres {


    function update_montant_apres($especes_tbl, $especesTableRepository, $especes, $i) {

        $especes_apres_total= 0;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_50_apres', 
            $especes[$i]->getNombre_50_apres() * 50,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_50_apres() * 50;



        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_20_apres', 
            $especes[$i]->getNombre_20_apres() * 20,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_20_apres() * 20;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_10_apres', 
            $especes[$i]->getNombre_10_apres() * 10,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_10_apres() * 10;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_5_apres', 
            $especes[$i]->getNombre_5_apres() * 5,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_5_apres() * 5;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_2_apres', 
            $especes[$i]->getNombre_2_apres() * 2,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_2_apres() * 2;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_1_apres', 
            $especes[$i]->getNombre_1_apres() * 1,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_1_apres() * 1;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_050_apres', 
            $especes[$i]->getNombre_050_apres() * 0.5,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_050_apres() * 0.50;


        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_020_apres', 
            $especes[$i]->getNombre_020_apres() * 0.20,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_020_apres() * 0.20;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_010_apres', 
            $especes[$i]->getNombre_010_apres() * 0.10,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_apres_total += $especes[$i]->getNombre_010_apres() * 0.10;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_apres', 
            $especes_apres_total,  
            'especes_id',
            $especes[$i]->getEspecesId()
        ); 
    }
}
