<?php
namespace App\Controller\Especes;


class UpdateRecette {

    function update_recette($especes_tbl, $especesTableRepository, $especes, $i) {
 
        $especesTableRepository->update( 
            $especes_tbl, 'recette', 
            $especes[$i]->getMontantApres() - $especes[$i]->getMontant() + $especes[$i]->getCheques() + $especes[$i]->getCb(),
            'especes_id',
            $especes[$i]->getEspecesId()
        );
    }
    function update_project($project_tbl, $projectTableRepository, $recette, $i) {
 
        $projectTableRepository->update_proj_montant( 
            $project_tbl, 'c_montant', 
            $recette,
            $i
        );
    }
}