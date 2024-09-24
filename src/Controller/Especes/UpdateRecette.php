<?php
namespace App\Controller\Especes;


class UpdateRecette {

    function update_recette($especes_tbl, $especesTableRepository, $especes, $i) {
 
        $especesTableRepository->update( 
            $especes_tbl, 'recette', 
            $especes[$i]->getMontantApres() - $especes[$i]->getMontant() + $especes[$i]->getCheques(),
            'especes_id',
            $especes[$i]->getEspecesId()
        );
    }
}