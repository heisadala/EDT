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
        $controller = $controllerTableRepository->findOneBy(['name' => $app]);

        $project_controller = $projectControllerTableRepository->findOneBy(['name' => 'PROJECT']);

        $project_table_name = $app_year . '_' . $project_controller->getTbl();
        $projectTableRepository->set_table_name($project_table_name);
        $affectation_list_1 = $projectTableRepository->get_affectation_list($project_table_name);

        $project_table_name = $app_year+1 . '_' . $project_controller->getTbl();
        $projectTableRepository->set_table_name($project_table_name);
        $affectation_list_2 = $projectTableRepository->get_affectation_list($project_table_name);


        $helloAssoApi = new HelloAssoApi;
        $resp = $helloAssoApi->getToken();
        $obj = json_decode($resp, true);
        $resp = $helloAssoApi->getPaiementsInfo($obj['access_token']);
        // echo $resp;
        $obj = json_decode($resp, true);
        // dd( $obj['data']);
        $counter = 0;
        $amount = 0;
        $donation_counter = 0;
        $donation_amount = 0;
        for ($i=0; $i < count($obj['data']); $i++){
            for ($j=0; $j < count($obj['data'][$i]['items']); $j++) {
                if ($obj['data'][$i]['items'][$j]['type'] == 'Registration') {
                    $counter = $counter + 1;
                    $amount = $amount + $obj['data'][$i]['items'][$j]['amount'];
                }
                if ($obj['data'][$i]['items'][$j]['type'] == 'Donation') {
                    $donation_counter = $donation_counter + 1;
                    $donation_amount = $donation_amount + $obj['data'][$i]['items'][$j]['amount'];
                }
            }
        }
        // echo $amount . "  " . $donation_amount;

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
            'meta_index' => 'index',
            'header_title' => $controller->getHeaderTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),
            
            'show_navbar' => true,
            'show_cards' => true,
            'username' => $username,
            'role' => $role,
            'affectation_1' => $affectation_list_1,
            'affectation_2' => $affectation_list_2,
            'participants' => $counter
        ]);
    }
}
