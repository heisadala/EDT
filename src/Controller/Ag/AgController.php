<?php

namespace App\Controller\Ag;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ControllerTableRepository;

class AgController extends AbstractController
{
    public function index(int $year, string $title,
                            ControllerTableRepository $controllerTableRepository
                                    ): Response
    {
        $app = $title;
        $controller = $controllerTableRepository->findOneBy(criteria: ['name' => $app]);
        $username = "";
        $role = "";
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $role = ($this->getUser()->getRoles())[0];
        }

/*         $show_carousel_ag = true;
        $show_carousel_photo = false;
        if ($subject == 'AG') {
            $show_carousel_ag = true;
            $show_carousel_photo = false;
        }
        else {
            $show_carousel_ag = false;
            $show_carousel_photo = true;
        }

 */        return $this->render('index.html.twig', [


            'controller_name' => $title . 'Controller',
            'server_base' => $_SERVER['BASE'],
            'meta_index' => 'noindex',
            'header_title' => $controller->getHeaderTitle(),
            'navbar_title' => $controller->getNavbarTitle(),
            'shortcut_icon' => $controller->getIcon(),
            'db' => $controller->getName(),
            'bg_color' => $controller->getBgColor(),

            'show_navbar' => true,
            'show_video' => true,
/*             'show_carousel_ag' => $show_carousel_ag,
            'show_carousel_photo' => $show_carousel_photo,
 */            




            'username' => $username,
            'role' => $role,       


        ]);
    }
}
