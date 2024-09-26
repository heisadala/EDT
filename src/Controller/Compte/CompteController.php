<?php

namespace App\Controller\Compte;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CompteTableRepository;
use App\Repository\CompteChequesTableRepository;
use App\Repository\ProjectTableRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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


    #[Route('/compte', name: 'app_compte')]
    public function index(
                            CompteTableRepository $compteTableRepository
                        ): Response
    {
        $app = 'COMPTE';
        $db = $compteTableRepository->findOneBy(array('name' => $app));

        $databases = $compteTableRepository->findAll();

        $username = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_gallery' => true,
            'background' => $db->getBackground(),
            'db' => $db->getName(),
            'databases' => $databases,
            'username' => $username,

        ]);
    }

    public function table(string $year,string $viewFormat, int $rowNumbers,
                            CompteTableRepository $compteTableRepository,
                            CompteChequesTableRepository $courantTableRepository,

                        ): Response
    {
        $app = 'TABLE';

        $db = $compteTableRepository->findOneBy(['name' => $app]);
        $table_header_fields = $courantTableRepository->fetch_header_fields_from_table($db->getTbl());
        $primary_key_name = $courantTableRepository->get_pk_name($db->getTbl());
        $primary_key_column = $this->get_pk_column($table_header_fields, $primary_key_name);

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
        $up_or_down = $sort_order == 'ASC' ? 'down' : 'up';
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

        $table_name = $year . '_' . $db->getTbl();
        $courantTableRepository->set_table_name($table_name);
        $courant_table_content = $courantTableRepository->fetch_class_from_table_ordered($table_name,
                                                                                    $sort, $sort_order);

        $showTable = true;
        $showGallery = false;
        if ($viewFormat == 'table') {
            $showTable = true;
            $showGallery = false;
        } else {
            $showTable = false;
            $showGallery = true;
        }

        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'server_name' => $_SERVER['SERVER_NAME'],
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_table' => true,
            'show_gallery' => false,
            'background' => $db->getBackground(),
            'db' => $db->getName(),
            'table_header_fields' => $table_header_fields,
            'courant_table_content' => $courant_table_content,
            'primary_key_name' => $primary_key_name,
            'primary_key_column' => $primary_key_column,
            'show_row_number' => $rowNumbers,
            'asc_or_desc' => $asc_or_desc,
            'up_or_down' => $up_or_down,
            'username' => $username,

        ]);
    }

    public function chart (string $chartFilter,
        CompteTableRepository $compteTableRepository,
        CompteChequesTableRepository $courantTableRepository,
    ): Response
    {

        $app = 'CHART';
        $db = $compteTableRepository->findOneby(['name' => $app]);
        $account = $courantTableRepository->findAll();

        $banks = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'banque');
        $affectation = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'affectation');
        $operations = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'operation');
        $categories = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'categorie');

        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
                'controller_name' => 'CompteController',
                'server_base' => $_SERVER['BASE'],
                'meta_index' => 'noindex',
                'title' => $app,
                'icon' => $db->getIcon(),
                'header_image' => 'Trestel_2.jpg',
                'show_navbar' => true,
                'db' => $db->getName(),
                'show_chart' => true,
                'account' => $account,
                'banks' => $banks,
                'affectation' => $affectation,
                'categories' => $categories,
                'operations' => $operations,
                'username' => $username,

        ]);
    }
    public function dashboard (
        CompteTableRepository $compteTableRepository,
        CompteChequesTableRepository $courantTableRepository,
        ProjectTableRepository $projectTableRepository,
    ): Response
    {

        $app = 'DASHBOARD';
        $db = $compteTableRepository->findOneby(['name' => $app]);
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
                'title' => $app,
                'icon' => $db->getIcon(),
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

    public function affectation (string $affectationFilter,
                            CompteTableRepository $compteTableRepository,
                            CompteChequesTableRepository $courantTableRepository,
                            ): Response
    {

        $app = 'AFFECTATION';
        $db = $compteTableRepository->findOneby(['name' => $app]);
        $account = $courantTableRepository->findAll();

        $banks = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'banque');
        $projects = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'affectation');
        $operations = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'operation');
        $categories = $courantTableRepository->fetch_column_unique_value($db->getTbl(), 'categorie');

        $username = "";
        if ($this->getUser()) {
        $username = $this->getUser()->getUsername();
        }

        return $this->render('index.html.twig', [
                'controller_name' => 'CompteController',
                'server_base' => $_SERVER['BASE'],
                'meta_index' => 'noindex',
                'title' => $app,
                'icon' => $db->getIcon(),
                'header_image' => 'Trestel_2.jpg',
                'show_navbar' => true,
                'db' => $db->getName(),
                'show_chart' => true,
                'account' => $account,
                'banks' => $banks,
                'projects' => $projects,
                'categories' => $categories,
                'operations' => $operations,
                'affectationFilter' => $affectationFilter,
                'username' => $username,

        ]);
}


    public function caisses(
                            CompteTableRepository $compteTableRepository
                        ): Response
    {
            $app = 'CAISSES';
            $db = $compteTableRepository->findOneBy(array('name' => $app));

            $databases = $compteTableRepository->findAll();

            $username = "";
            if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            }

            return $this->render('index.html.twig', [
                'controller_name' => 'CompteController',
                'server_base' => $_SERVER['BASE'],
                'meta_index' => 'noindex',
                'title' => ucfirst(strtolower($app)),
                'icon' => $db->getIcon(),
                'header_image' => 'Trestel_2.jpg',
                'show_navbar' => true,
                'show_gallery' => false,
                'background' => $db->getBackground(),
                'db' => $db->getName(),
                'databases' => $databases,
                'username' => $username,

            ]);
    }


    public function livret(
        CompteTableRepository $compteTableRepository
    ): Response
    {
            $app = 'LIVRET';
            $db = $compteTableRepository->findOneBy(array('name' => $app));

            $databases = $compteTableRepository->findAll();

            $username = "";
            if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            }

            return $this->render('index.html.twig', [
            'controller_name' => 'CompteController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_gallery' => false,
            'background' => $db->getBackground(),
            'db' => $db->getName(),
            'databases' => $databases,
            'username' => $username,

        ]);
    }

    public function add (
                            CompteTableRepository $compteTableRepository,
                            CompteChequesTableRepository $courantTableRepository,

                        ): Response
    {
        $app = 'COURANT';
        $db = $compteTableRepository->findOneBy(array('name' => $app));
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
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_table' => false,
            'show_gallery' => false,
            'background' => $db->getBackground(),
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
                            CompteTableRepository $compteTableRepository,
                            CompteChequesTableRepository $courantTableRepository,

                        ): Response
    {
        $app = 'COURANT';
        $db = $compteTableRepository->findOneBy(array('name' => $app));
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
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_table' => false,
            'show_gallery' => false,
            'background' => $db->getBackground(),
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
                            CompteTableRepository $compteTableRepository,
                            CompteChequesTableRepository $courantTableRepository,

                        ): Response

    {
        $app = 'COURANT';
        $db = $compteTableRepository->findOneBy(array('name' => $app));
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
            'title' => ucfirst(strtolower($app)),
            'icon' => $db->getIcon(),
            'header_image' => 'Trestel_2.jpg',
            'show_navbar' => true,
            'show_table' => false,
            'show_gallery' => false,
            'background' => $db->getBackground(),
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
}
