<?php
namespace App\Controller\Especes;


class UpdateCaisse {

    function update_caisse($especes_tbl, $especesTableRepository, $especes, $i) {


        $total_nombre_50_debut = $especes[0]->getNombre_50();
        $total_nombre_50_avant = 0;
        $total_nombre_50_apres = 0;

        $total_nombre_20_debut = $especes[0]->getNombre_20();
        $total_nombre_20_avant = 0;
        $total_nombre_20_apres = 0;

        $total_nombre_10_debut = $especes[0]->getNombre_10();
        $total_nombre_10_avant = 0;
        $total_nombre_10_apres = 0;

        $total_nombre_5_debut = $especes[0]->getNombre_5();
        $total_nombre_5_avant = 0;
        $total_nombre_5_apres = 0;

        $total_nombre_2_debut = $especes[0]->getNombre_2();
        $total_nombre_2_avant = 0;
        $total_nombre_2_apres = 0;

        $total_nombre_1_debut = $especes[0]->getNombre_1();
        $total_nombre_1_avant = 0;
        $total_nombre_1_apres = 0;

        $total_nombre_050_debut = $especes[0]->getNombre_050();
        $total_nombre_050_avant = 0;
        $total_nombre_050_apres = 0;

        $total_nombre_020_debut = $especes[0]->getNombre_020();
        $total_nombre_020_avant = 0;
        $total_nombre_020_apres = 0;

        $total_nombre_010_debut = $especes[0]->getNombre_010();
        $total_nombre_010_avant = 0;
        $total_nombre_010_apres = 0;


        for ($i=1; $i < count($especes); $i++) {

            $total = 0;
            $total_nombre_50_avant += $especes[$i]->getNombre_50();
            $total_nombre_50_apres += $especes[$i]->getNombre_50_apres();
            $total_nombre_50 = $total_nombre_50_debut - $total_nombre_50_avant + $total_nombre_50_apres; 
            $total += $total_nombre_50 * 50;

            $total_nombre_20_avant += $especes[$i]->getNombre_20();
            $total_nombre_20_apres += $especes[$i]->getNombre_20_apres();
            $total_nombre_20 = $total_nombre_20_debut - $total_nombre_20_avant + $total_nombre_20_apres; 
            $total += $total_nombre_20 * 20;


            $total_nombre_10_avant += $especes[$i]->getNombre_10();
            $total_nombre_10_apres += $especes[$i]->getNombre_10_apres();
            $total_nombre_10 = $total_nombre_10_debut - $total_nombre_10_avant + $total_nombre_10_apres; 
            $total += $total_nombre_10 * 10;

            $total_nombre_5_avant += $especes[$i]->getNombre_5();
            $total_nombre_5_apres += $especes[$i]->getNombre_5_apres();
            $total_nombre_5 = $total_nombre_5_debut - $total_nombre_5_avant + $total_nombre_5_apres; 
            $total += $total_nombre_5 * 5;

            $total_nombre_2_avant += $especes[$i]->getNombre_2();
            $total_nombre_2_apres += $especes[$i]->getNombre_2_apres();
            $total_nombre_2 = $total_nombre_2_debut - $total_nombre_2_avant + $total_nombre_2_apres; 
            $total += $total_nombre_2 * 2;

            $total_nombre_1_avant += $especes[$i]->getNombre_1();
            $total_nombre_1_apres += $especes[$i]->getNombre_1_apres();
            $total_nombre_1 = $total_nombre_1_debut - $total_nombre_1_avant + $total_nombre_1_apres; 
            $total += $total_nombre_1 * 1;

            $total_nombre_050_avant += $especes[$i]->getNombre_050();
            $total_nombre_050_apres += $especes[$i]->getNombre_050_apres();
            $total_nombre_050 = $total_nombre_050_debut - $total_nombre_050_avant + $total_nombre_050_apres; 
            $total += $total_nombre_050 * 0.50;

            $total_nombre_020_avant += $especes[$i]->getNombre_020();
            $total_nombre_020_apres += $especes[$i]->getNombre_020_apres();
            $total_nombre_020 = $total_nombre_020_debut - $total_nombre_020_avant + $total_nombre_020_apres; 
            $total += $total_nombre_020 * 0.20;

            $total_nombre_010_avant += $especes[$i]->getNombre_010();
            $total_nombre_010_apres += $especes[$i]->getNombre_010_apres();
            $total_nombre_010 = $total_nombre_010_debut - $total_nombre_010_avant + $total_nombre_010_apres; 
            $total += $total_nombre_010 * 0.10;


        }
        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_50_apres', 
            $total_nombre_50,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_50_apres', 
            $total_nombre_50 * 50,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_20_apres', 
            $total_nombre_20,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_20_apres', 
            $total_nombre_20 * 20,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_10_apres', 
            $total_nombre_10,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_10_apres', 
            $total_nombre_10 * 10,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_5_apres', 
            $total_nombre_5,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_5_apres', 
            $total_nombre_5 * 5,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_2_apres', 
            $total_nombre_2,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_2_apres', 
            $total_nombre_2 * 2,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_1_apres', 
            $total_nombre_1,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_1_apres', 
            $total_nombre_1 * 1,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_050_apres', 
            $total_nombre_050,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_050_apres', 
            $total_nombre_050 * 0.50,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_020_apres', 
            $total_nombre_020,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_020_apres', 
            $total_nombre_020 * 0.20,  
            'especes_id',
            $especes[0]->getEspecesId()
        );

        $especesTableRepository->update( 
            $especes_tbl, 
            'nombre_010_apres', 
            $total_nombre_010,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'montant_010_apres', 
            $total_nombre_010 * 0.10,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
        $especesTableRepository->update( 
            $especes_tbl, 
            'recette', 
            $total,  
            'especes_id',
            $especes[0]->getEspecesId()
        );
    }
}