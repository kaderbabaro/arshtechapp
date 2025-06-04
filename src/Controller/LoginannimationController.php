<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginannimationController extends AbstractController
{
    #[Route('/loginannimation', name: 'app_loginannimation')]
    public function index(): Response
    {
        return $this->render('loginannimation/index.html.twig', [
            'controller_name' => 'LoginannimationController',
        ]);
    }
}
