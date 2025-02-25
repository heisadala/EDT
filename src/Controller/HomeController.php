<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ControllerTableRepository;
use App\Repository\ProjectControllerTableRepository;
use App\Repository\ProjectTableRepository;
use App\Controller\HelloAssoApi;

class HomeController extends AbstractController
{
    public function index (string $title, 
                            ControllerTableRepository $controllerTableRepository,
                            ProjectControllerTableRepository $projectControllerTableRepository,
                            ProjectTableRepository $projectTableRepository): Response
    {
        // HOME
        $app = $title;
        $app_year = $this->getParameter('app.year');
        $controller_column_name = $this->getParameter('app.controller_column_name');
        $controller = $controllerTableRepository->findOneBy([$controller_column_name => $app]);

        $project_controller_name = $this->getParameter('app.project_controller_name');
        $project_controller = $projectControllerTableRepository->findOneBy
            ([$controller_column_name => $project_controller_name]);

        $project_table_name = $app_year . '_' . $project_controller->getTbl();
        $projectTableRepository->set_table_name($project_table_name);
        $affectation_list_1 = $projectTableRepository->get_affectation_list($project_table_name);

        $project_table_name = $app_year+1 . '_' . $project_controller->getTbl();
        $projectTableRepository->set_table_name($project_table_name);
        $affectation_list_2 = $projectTableRepository->get_affectation_list($project_table_name);

        $helloAssoApi = new HelloAssoApi;
        $participants = $helloAssoApi->getParticipants();

        $username = "";
        $role = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $role = ($this->getUser()->getRoles())[0];
        }
        if ($_SERVER['BASE'] == '') { $_SERVER['BASE'] = '/EDT/public';}

        return $this->render('index.html.twig', [
            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => $controller->getMetaIndex(),
            'db' => $controller->getName(),
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'bg_color' => $controller->getBgColor(),
            'year' => $app_year,
            
            'show_navbar' => true,
            'show_cards' => true,

            'username' => $username,
            'role' => $role,

            'affectation_1' => $affectation_list_1,
            'affectation_2' => $affectation_list_2,
            'participants' => $participants
        ]);
    }
}
