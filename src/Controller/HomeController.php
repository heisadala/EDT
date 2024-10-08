<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HomeTableRepository;
use App\Repository\ProjectTableRepository;

class HomeController extends AbstractController
{
    public function index(HomeTableRepository $homeTableRepository,
                            ProjectTableRepository $projectTableRepository,): Response
    {

        $app = $this->getParameter('app.application_name');
        $table_name = $this->getParameter('app.database_home_table_name');
        $year = $this->getParameter('app.year');
        $db = $homeTableRepository->findOneby(['name' => $table_name]);

        $sql_cmd = "SELECT structure FROM " . $year . "_project_table WHERE structure != 'EDT' GROUP BY structure ORDER by structure ASC;";
        $structure = $projectTableRepository->send_sql_cmd($sql_cmd);

        $username = "";
        $role = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $role = ($this->getUser()->getRoles())[0];
        }
        if ($_SERVER['BASE'] == '') { $_SERVER['BASE'] = '/EDT/public';}

        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'index',
            'title' => 'Accueil ' . $app,
            'icon' => $db->getIcon(),
            'show_navbar' => true,
            'show_cards' => true,
            'db' => $db->getName(),
            'username' => $username,
            'role' => $role,
            'structure' => $structure,
        ]);
    }
}
