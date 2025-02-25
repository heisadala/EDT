<?php

namespace App\Controller\Compte;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CompteControllerTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\ProjectTableRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Repository\ProjectControllerTableRepository;
use App\Repository\EdtTableRepository;
use App\Repository\YearTableRepository;

class CompteController extends AbstractController
{
    function get_pk_column($table_header_fields, $table_primary_key_name)
    {
        $i = 0;
        $pk_column = 0;
        foreach ($table_header_fields as $header_field) {
            $i++;
            if (strcmp($header_field['Field'], $table_primary_key_name) == 0) {
                $pk_column = $i;
            }
        }
        return $pk_column;
    }

    public function download(string $facture): BinaryFileResponse
    {
        // send the file contents and force the browser to download it
        return $this->file('https://' . $_SERVER['SERVER_NAME'] . '/DEV_EDT/FACTURES/CAMSP_28.pdf');
    }


     public function table(int $year, string $viewFormat, int $rowNumbers, string $title,
                            CompteControllerTableRepository $compteControllerTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            YearTableRepository $yearTableRepository,
                                                ): Response
    {
        // TABLE
        $app = $title;
        $controller = $compteControllerTableRepository->findOneBy(['name' => $app]);

        $table_name = $year . '_' . $controller->getTbl();
        $courantTableRepository->set_table_name($table_name);

        $table_header_fields = $courantTableRepository->fetch_header_fields_from_table($table_name);
        $primary_key_name = $courantTableRepository->get_pk_name($table_name);
        $primary_key_column = $this->get_pk_column($table_header_fields, $primary_key_name);

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
        $up_or_down = $sort_order == 'ASC' ? 'down' : 'up';
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

        $courant_table_content = $courantTableRepository->fetch_class_from_table_ordered($table_name,
                                                                                    $sort, $sort_order);
        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }
        $year_table = $yearTableRepository->findOneBy(['year_id' => $year]);
        $credit_debut_annee = $year_table->getCc_begin();

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_table' => true,
            'show_gallery' => false,

            'table_header_fields' => $table_header_fields,
            'courant_table_content' => $courant_table_content,
            'primary_key_name' => $primary_key_name,
            'primary_key_column' => $primary_key_column,
            'show_row_number' => $rowNumbers,
            'asc_or_desc' => $asc_or_desc,
            'up_or_down' => $up_or_down,
            'username' => $username,
            'year' => $year,
            'credit_debut_annee' => $credit_debut_annee,
        ]);
    }

    public function chart (int $year, string $chartFilter, string $title,
        CompteControllerTableRepository $compteControllerTableRepository,
        CompteChequesTableRepository $courantTableRepository,
    ): Response
    {

        $app = $title;
        $controller = $compteControllerTableRepository->findOneBy(['name' => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $courantTableRepository->set_table_name($table_name);
        $account = $courantTableRepository->findAll();

        $banks = $courantTableRepository->fetch_column_unique_value($table_name, 'banque');
        $affectation = $courantTableRepository->fetch_column_unique_value($table_name, 'affectation');
        $operations = $courantTableRepository->fetch_column_unique_value($table_name, 'operation');
        $categories = $courantTableRepository->fetch_column_unique_value($table_name, 'categorie');

        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),
            

                'header_image' => 'Trestel_2.jpg',
                'show_navbar' => true,
                'show_chart' => true,
                'account' => $account,
                'banks' => $banks,
                'affectation' => $affectation,
                'categories' => $categories,
                'operations' => $operations,
                'username' => $username,
                'year' => $year,

        ]);
    }

    public function affectation (int $year, string $affectationFilter, string $title,
                                    CompteControllerTableRepository $compteControllerTableRepository,
                                    ProjectControllerTableRepository $projectControllerTableRepository,
                                    CompteChequesTableRepository $courantTableRepository,
                                    ProjectTableRepository $projectTableRepository,
                                    EdtTableRepository $edtTableRepository,
                                    ): Response
    {

        $app = $title;
        $controller = $compteControllerTableRepository->findOneBy(['name' => $app]);
        $table_name = $year . '_' . $controller->getTbl();
        $courantTableRepository->set_table_name($table_name);
        $account = $courantTableRepository->findAll();


        $proj_controller = $projectControllerTableRepository->findOneBy(['name' => 'PROJECT']);
        $proj_table_name = $year . '_' . $proj_controller->getTbl();
        $projectTableRepository->set_table_name($proj_table_name);
        $projets = $projectTableRepository->findAll();

        $banks = $courantTableRepository->fetch_column_unique_value($table_name, 'banque');
        $affectation = $courantTableRepository->fetch_column_unique_value($table_name, 'affectation');
        $operations = $courantTableRepository->fetch_column_unique_value($table_name, 'operation');
        $categories = $courantTableRepository->fetch_column_unique_value($table_name, 'categorie');


        $proj_affectation = $projectTableRepository->fetch_column_unique_value($proj_table_name, 'affectation');

        $edt_controller = $compteControllerTableRepository->findOneBy(['name' => 'EDT']);
        $edt_table_name = $year . '_' . $edt_controller->getTbl();
        $edtTableRepository->set_table_name($edt_table_name);
        $edts = $edtTableRepository->findAll();

        $sql_cmd = "SELECT affectation FROM $edt_table_name WHERE affectation LIKE '%EDT%' GROUP BY affectation ORDER by affectation ASC;";
        $edt_affectation = $edtTableRepository->send_sql_cmd($sql_cmd);


        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }
        $show_table = false;
        $show_chart = true;
        if ($affectationFilter == 'PROJET' or $affectationFilter == 'EDT') {
            $show_table = true;
            $show_chart = false;
        }
        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

                'header_image' => 'Trestel_2.jpg',
                'show_navbar' => true,
                'show_chart' => $show_chart,
                'show_table' => $show_table,
                'account' => $account,
                'projets' => $projets,
                'banks' => $banks,
                'affectation' => $affectation,
                'categories' => $categories,
                'operations' => $operations,
                'affectationFilter' => $affectationFilter,
                'username' => $username,
                'year' => $year,
                'proj_affectation' => $proj_affectation,
                'edt_affectation' => $edt_affectation,
                'edts' => $edts,

        ]);
}


    public function livret(
        CompteControllerTableRepository $compteControllerTableRepository,
        ): Response
    {
            $app = 'LIVRET';
            $db = $compteControllerTableRepository->findOneBy(array('name' => $app));

            $databases = $compteControllerTableRepository->findAll();

            $username = "";
            if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            }

            return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => ucfirst(strtolower($app)),
            'shortcut_icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_gallery' => false,
            'db' => $db->getName(),
            'databases' => $databases,
            'username' => $username,

        ]);
    }

    public function add (
        CompteControllerTableRepository $compteControllerTableRepository,
        CompteChequesTableRepository $courantTableRepository,

                        ): Response
    {
        $app = 'COURANT';
        $db = $compteControllerTableRepository->findOneBy(array('name' => $app));
        $table_header_fields = $courantTableRepository->fetch_header_fields_from_table($db->getTbl());
        $primary_key_name = $courantTableRepository->get_pk_name($db->getTbl());
        $primary_key_column = $this->get_pk_column($table_header_fields, $primary_key_name);

        $sort = isset($_GET['sort']) ? $_GET['sort'] : $primary_key_name;
        $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
        $up_or_down = $sort_order == 'ASC' ? 'down' : 'up';
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

        $courant_table_content = $courantTableRepository->fetch_class_from_table_ordered($db->getTbl(),
                                                                    $sort, $sort_order);

        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'server_name' => $_SERVER['SERVER_NAME'],
            'meta_index' => 'noindex',
            'header_title' => ucfirst(strtolower($app)),
            'shortcut_icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_table' => false,
            'show_gallery' => false,
            'db' => $db->getName(),
            'table_header_fields' => $table_header_fields,
            'courant_table_content' => $courant_table_content,
            'primary_key_name' => $primary_key_name,
            'primary_key_column' => $primary_key_column,
            'asc_or_desc' => $asc_or_desc,
            'up_or_down' => $up_or_down,
            'username' => $username,

        ]);
    }

    public function edit (string $pk_name, int $ref,
    CompteControllerTableRepository $compteControllerTableRepository,
    CompteChequesTableRepository $courantTableRepository,

                        ): Response
    {
        $app = 'COURANT';
        $db = $compteControllerTableRepository->findOneBy(array('name' => $app));
        $table_header_fields = $courantTableRepository->fetch_header_fields_from_table($db->getTbl());
        $primary_key_name = $courantTableRepository->get_pk_name($db->getTbl());
        $primary_key_column = $this->get_pk_column($table_header_fields, $primary_key_name);

        $sort = isset($_GET['sort']) ? $_GET['sort'] : $primary_key_name;
        $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
        $up_or_down = $sort_order == 'ASC' ? 'down' : 'up';
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

        $courant_table_content = $courantTableRepository->fetch_class_from_table_ordered($db->getTbl(),
                                                                    $sort, $sort_order);


        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'server_name' => $_SERVER['SERVER_NAME'],
            'meta_index' => 'noindex',
            'header_title' => ucfirst(strtolower($app)),
            'shortcut_icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_table' => false,
            'show_gallery' => false,
            'db' => $db->getName(),
            'table_header_fields' => $table_header_fields,
            'courant_table_content' => $courant_table_content,
            'primary_key_name' => $primary_key_name,
            'primary_key_column' => $primary_key_column,
            'asc_or_desc' => $asc_or_desc,
            'up_or_down' => $up_or_down,
            'username' => $username,

        ]);
    }

    public function delete (string $pk_name, int $ref,
    CompteControllerTableRepository $compteControllerTableRepository,
    CompteChequesTableRepository $courantTableRepository,

                        ): Response

    {
        $app = 'COURANT';
        $db = $compteControllerTableRepository->findOneBy(array('name' => $app));
        $table_header_fields = $courantTableRepository->fetch_header_fields_from_table($db->getTbl());
        $primary_key_name = $courantTableRepository->get_pk_name($db->getTbl());
        $primary_key_column = $this->get_pk_column($table_header_fields, $primary_key_name);

        $sort = isset($_GET['sort']) ? $_GET['sort'] : $primary_key_name;
        $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
        $up_or_down = $sort_order == 'ASC' ? 'down' : 'up';
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

        $courant_table_content = $courantTableRepository->fetch_class_from_table_ordered($db->getTbl(),
                                                                    $sort, $sort_order);


        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'server_name' => $_SERVER['SERVER_NAME'],
            'meta_index' => 'noindex',
            'header_title' => ucfirst(strtolower($app)),
            'shortcut_icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_table' => false,
            'show_gallery' => false,
            'db' => $db->getName(),
            'table_header_fields' => $table_header_fields,
            'courant_table_content' => $courant_table_content,
            'primary_key_name' => $primary_key_name,
            'primary_key_column' => $primary_key_column,
            'asc_or_desc' => $asc_or_desc,
            'up_or_down' => $up_or_down,
            'username' => $username,

        ]);
    }

    public function dashboard (
        CompteControllerTableRepository $compteControllerTableRepository,
        CompteChequesTableRepository $courantTableRepository,
        ProjectTableRepository $projectTableRepository,
    ): Response
    {

        $app = 'DASHBOARD';
        $db = $compteControllerTableRepository->findOneby(['name' => $app]);
        $projets = $projectTableRepository->findAll();
        $account = $courantTableRepository->findAll();

        // $banks = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'banque');
        // $projects = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'projet');
        // $operations = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'operation');
        // $categories = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'categorie');

        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
                'controller_name' => 'CompteController',
                'server_base' => $_SERVER['BASE'],
                'meta_index' => 'noindex',
                'header_title' => $app,
                'shortcut_icon' => $db->getIcon(),
                'header_image' => 'Trestel_2.jpg',
                'show_navbar' => true,
                'db' => $db->getName(),
                'show_dashboard' => true,
                'projets' => $projets,
                'account' => $account,
                // 'banks' => $banks,
                // 'projects' => $projects,
                // 'categories' => $categories,
                // 'operations' => $operations,
                'username' => $username,

        ]);
    }

}
