<?php
namespace App\Controller\Especes;


class UpdateMontantAvant {


    function update_montant_avant($especes_tbl, $especesTableRepository, $especes, $i) {


        $especes_avant_total= 0;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_50', 
            $especes[$i]->getNombre_50() * 50,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_50() * 50;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_20', 
            $especes[$i]->getNombre_20() * 20,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_20() * 20;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_10', 
            $especes[$i]->getNombre_10() * 10,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_10() * 10;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_5', 
            $especes[$i]->getNombre_5() * 5,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_5() * 5;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_2', 
            $especes[$i]->getNombre_2() * 2,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_2() * 2;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_1', 
            $especes[$i]->getNombre_1() * 1,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_1() * 1;
    
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_050', 
            $especes[$i]->getNombre_050() * 0.5,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_050() * 0.50;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_020', 
            $especes[$i]->getNombre_020() * 0.20,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_020() * 0.20;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_010', 
            $especes[$i]->getNombre_010() * 0.10,  
            'especes_id',
            $especes[$i]->getEspecesId()
        );
        $especes_avant_total += $especes[$i]->getNombre_010() * 0.10;

        $especesTableRepository->update( 
            $especes_tbl, 
            'montant', 
            $especes_avant_total,  
            'especes_id',
            $especes[$i]->getEspecesId()
        ); 
    }
}
