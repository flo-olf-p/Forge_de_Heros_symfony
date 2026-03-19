<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function app_home() : Response
    {
        return $this->render('home.html.twig');
    }

    // Paths of the api
    #[Route('/api', name: 'api_home')]
    public function api_home() : Response
    {
        return $this->render('api/api.html.twig');
    }

}
